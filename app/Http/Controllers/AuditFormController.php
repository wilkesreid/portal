<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AuditForm;
use App\AuditFormField;
use Response;
use Storage;

class AuditFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(AuditForm::get());
    }
    
    public function indexDeletedFields($form_id) {
        return Response::json(AuditFormField::onlyTrashed()->orderBy('deleted_at','asc')->get());
    }
    
    public function show($id) {
        return Response::json(AuditForm::find($id));
    }
    
    public function frozen($id) {
        return Response::json(['frozen' => AuditForm::find($id)->frozen]);
    }
    
    public function indexFields($id) {
        return Response::json(AuditFormField::where('audit_form_id',$id)->get());
    }
    
    public function freeze($id) {
        $form = AuditForm::find($id);
        
        $form->frozen = true;
        
        $form->save();
        
        return Response::json(['success' => true]);
    }
    
    public function unfreeze($id) {
        $form = AuditForm::find($id);
        
        $form->frozen = false;
        
        $form->save();
        
        return Response::json(['success' => true]);
    }
    
    public function duplicate($id) {
        $form = AuditForm::find($id);
        
        $new_form = $form->replicate();
        
        $new_form->name = $form->name . " (copy)";
        $new_form->id = 0;
        
        $new_form->save();
        
        $new_form_id = $new_form->id;
        
        $fields = $form->fields;
        $prev_field = null;
        foreach ($fields as $field) {
            $new_field = $field->replicate();
            $new_field->audit_form_id = $new_form_id;
            $new_field->order = null;
            $new_field->save();
            if ($prev_field != null) {
                $prev_field->order = $new_field->id;
                $prev_field->save();
            }
            $prev_field = $new_field;
        }
        
        return Response::json(['success' => true]);
    }
    
    public function upload(Request $request, $id) {
        $field = AuditFormField::find($id);
        
        $s3client = Storage::disk('s3')->getAdapter()->getClient();
        
        $filename = $id."_".$request->input('name');
        $oldfilename = $field->value;
        
        if ($request->hasFile('file')) {
            if (Storage::disk('s3')->has($oldfilename)) {
                Storage::disk('s3')->delete($oldfilename);
            }
            Storage::disk('s3')->put($filename, file_get_contents($request->file('file')->getRealPath()));
        }
        
        $field->value = $filename;
        
        $field->save();
        
        return Response::json(['success' => true, 'url' => $filename]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        AuditForm::create([
            'id' => 0,
            'name' => $request->input('name'),
            'frozen' => false
        ]);
        
        return Response::json(['success' => true]);
    }
    
    public function createField(Request $request, $form_id) {
        
        $field = new AuditFormField();
        
        $field->audit_form_id = $form_id;
        $field->name = $request->input('name');
        $field->value = $request->input('value');
        $field->column_size = $request->input('column_size');
        $field->order = null;
        $field->tag = $request->input('tag');
        $field->attributes = json_encode($request->input('attributes'));
        $field->options = json_encode($request->input('options'));
        
        $field->save();
        
        $before_field = AuditFormField::withTrashed()->where('order', null)->where('audit_form_id', $form_id)->first();
        
        $before_field->order = $field->id;
        
        $before_field->save();
        
        return Response::json(['success' => true, 'id' => $field->id]);
    }
    
    public function createFieldAfter(Request $request, $form_id, $after_id) {
        
        $before_field = AuditFormField::find($after_id);
        
        $field = new AuditFormField();
        
        $field->audit_form_id = $form_id;
        $field->name = $request->input('name');
        $field->value = $request->input('value');
        $field->column_size = $request->input('column_size');
        $field->order = $before_field->order;
        $field->tag = $request->input('tag');
        $field->attributes = json_encode($request->input('attributes'));
        $field->options = json_encode($request->input('options'));
        
        $field->save();
        
        $before_field->order = $field->id;
        
        $before_field->save();
        
        return Response::json(['success' => true, 'id' => $field->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form = AuditForm::find($id);
        
        $form->name = $request->input('name');
        
        $form->save();
        
        return Response::json(['success' => true]);
    }
    
    public function updateField(Request $request, $id) {
        
        $field = AuditFormField::find($id);
        
        if ($request->has('name'))
        $field->name = $request->input('name');
        
        if ($request->has('column_size'))
        $field->column_size = $request->input('column_size');
        
        $field->value = $request->input('value');
        
        if ($request->has('tag'))
        $field->tag = $request->input('tag');
        
        if ($request->has('attributes'))
        $field->attributes = json_encode($request->input('attributes'));
        
        if ($request->has('options'))
        $field->options = json_encode($request->input('options'));
        
        $field->save();
        
        return Response::json(['success' => true]);
        
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AuditForm::destroy($id);
        
        AuditFormField::where('audit_form_id',$id)->forceDelete();
        
        return Response::json(['success' => true]);
    }
    
    public function destroyField($id) {
        $this_field = AuditFormField::find($id);
        $prev_field = AuditFormField::where('audit_form_id', $this_field->audit_form_id)->where('order', $id)->first();
        
        $prev_field->order = $this_field->order;
        
        $prev_field->save();
        
        AuditFormField::destroy($id);
        
        return Response::json(['success' => true]);
    }
    
    public function restoreField($id) {
        $this_field = AuditFormField::withTrashed()->find($id);
        if (!$this_field->trashed()) {
            return Response::json(['success' => true]);
        }
        $prev_field = AuditFormField::where('audit_form_id', $this_field->audit_form_id)->where('order', $this_field->order)->first();
        
        $prev_field->order = $id;
        $prev_field->save();
        
        $this_field->restore();
        
        return Response::json(['success' => true]);
    }
}
