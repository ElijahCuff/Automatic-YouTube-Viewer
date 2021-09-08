<?php
if(hasParam('url'))
{
$target = urldecode(rawurldecode($_REQUEST["url"]));
$id = getYtId($target);
$user = $_SERVER['HTTP_USER_AGENT'];
$ip = get_ip();

$log = "log.txt";

$userStr = $ip." ---> ".$id;
logStr($userStr);
$count = countLog($userStr,true);
$idCount = countLog($userStr,false);
}
else
{
exit("Invalid URL");
}




function hasParam($param) 
{
   return array_key_exists($param, $_REQUEST);
}

function getYtId($url) {
preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
return $matches[1];
}

function get_ip() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR','HTTP_CF_CONNECTING_IP') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}

function logStr($str)
{
global $log;
    if(file_exists($log))
    {
        file_put_contents($log,$str."\n",FILE_APPEND);
    }
    else
    {
       file_put_contents($log,$str."\n");
    }
}

function countLog($target, $unique)
{
global $log;
    if(file_exists($log))
    {
   $logData = file($log);
   $occur = 0;
   foreach($logData as $line)
       {
          if($unique)
              {
                if((trim($line) == trim($target)))
                  {

                 $occur++;
                  }
           }
          else
           {
               // id loads
              $parts = explode(" ---> ",trim($line));
              $partsTarg = explode(" ---> ",trim($target));
              if($parts[1] == $partsTarg[1])
               {
                  $occur++;
               }
           }
       }
      return $occur;
   }
  return 0;
}
?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

  <body>
<div style="height:100%;width:100%">
    <iframe id="existing-iframe-example"
        style="width:100%; height:260px;"
        src="https://www.youtube.com/embed/<?php echo $id;?>?enablejsapi=1"
        frameborder="0"
        style="border: solid 1px #37474F"
></iframe>
<div>
<?php
echo '<p>'.$count.' views from : '.$ip.',<br>View confirmation : '.(($count >2)?"Failed, too many loads from the same device.":"Successful, loads are within a reasonable amount.").'<br><br>Debugging for "'.$id.'"<br>ID Loads : '.$idCount.'<br>IP & ID Loads : '.$count.'<br>IP Address : '.$ip.'<br>User-Agent : '.$user.'</p>';
?>
</div>
</div>
<script type="text/javascript">
  var tag = document.createElement('script');
  tag.id = 'iframe-demo';
  tag.src = 'https://www.youtube.com/iframe_api';
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  var player;
  function onYouTubeIframeAPIReady() {
    player = new YT.Player('existing-iframe-example', {
        events: {
          'onReady': onPlayerReady,
          'onStateChange': onPlayerStateChange
        }
    });
  }
  function onPlayerReady(event) {
var pl = event.target;
pl.mute();
pl.playVideo();

  }
  function changeBorderColor(playerStatus) {
    var color;
    if (playerStatus == -1) {
      color = "#37474F"; // unstarted = gray
    } else if (playerStatus == 0) {
      color = "#FFFF00"; // ended = yellow
    } else if (playerStatus == 1) {
      color = "#33691E"; // playing = green
    } else if (playerStatus == 2) {
      color = "#DD2C00"; // paused = red
    } else if (playerStatus == 3) {
      color = "#AA00FF"; // buffering = purple
    } else if (playerStatus == 5) {
      color = "#FF6DOO"; // video cued = orange
    }
    if (color) {
 document.getElementById('existing-iframe-example').style.borderColor = color;
    }
  }
  function onPlayerStateChange(event) {
    changeBorderColor(event.data);

  }
</script>
  </body>
</html>
