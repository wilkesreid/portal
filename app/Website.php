<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = ['name','url','checked_last'];
    protected $appends = ['malware', 'pixel'];
    
    public function getMalwareAttribute() {
	    $url = urlencode($this->attributes['url']);
	    return file_get_contents("https://sb-ssl.google.com/safebrowsing/api/lookup?client=portal&key=AIzaSyCbmYZHMNMLGN1lygeVrlIM3AKmYgWhgq8&appver=1.0.0&pver=3.1&url=$url");
    }
    
    public function getPixelAttribute() {
        /*$url = $this->attributes['url'];
        
        // Retrieve string of url
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $output = curl_exec($ch);
        
        curl_close($ch);
        
        // Find Facebook pixel in string
        
        if (strpos($output, "!function(f,b,e,v,n,t,s)") > -1) {
            return true;
        }
        
        // If can't find Facebook pixel in html of page, look for it in javascript files referenced on page
        
        // Get all javascript urls on page
        preg_match_all('@<script[^>]*src=(["\'])(?P<src>[^"\']*)\1[^>]*>(.*?)</script>@' , $output, $matches);
        
        // Loop through every javascript url, retrieve its contents, and check them for the pixel
        if (sizeof($matches['src']) > 0) {
            for ($i=0;$i<sizeof($matches['src']);$i++) {
                $ch = curl_init();
                
                curl_setopt($ch, CURLOPT_URL, $matches['src'][$i]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                $output = curl_exec($ch);
                
                curl_close($ch);
                
                if (strpos($output, "!function(f,b,e,v,n,t,s)") > -1) {
                    return true;
                }
            }
        }*/
        
        return true;//false;
    }
}
