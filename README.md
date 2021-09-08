# Automatic-YouTube-Viewer
Automatically view a YouTube video in HTML &amp; PHP

    
How it works,     
- The video I want to load is at `https://youtu.be/pIqc3YQIbEg`    
- The automatic video player is at `https://loadwatch.herokuapp.com/index.php`     
- The parameter to enter a url is `?url=`     
- So my link looks like `https://loadwatch.herokuapp.com/index.php?url=https://youtu.be/pIqc3YQIbEg`         
  
   
If someone opens that link, they'll automatically count as a viewer on the video.     
   
In a Link "Masquerade" attack, this page can serve as a way to gain YouTube viewers.   
      
This could also be adapted into a URL shortener service for revenue, the user must watch the video and when it's finished, the user can continue to their website.
   
### Deployment
#### Create a FREE account first if you do not yet have one:      
https://signup.heroku.com/       
      
#### Deploy to Heroku Account
[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)
