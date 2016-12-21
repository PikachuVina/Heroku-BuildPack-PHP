http {
    include       mime.types;
    default_type  application/octet-stream;

    #log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
    #                  '$status $body_bytes_sent "$http_referer" '
    #                  '"$http_user_agent" "$http_x_forwarded_for"';

    #access_log  logs/access.log  main;

    sendfile        on;
    #tcp_nopush     on;

    #keepalive_timeout  0;
    keepalive_timeout  65;

    gzip  on;

    server_tokens off;

    fastcgi_buffers 256 4k;

    # define an easy to reference name that can be used in fastgi_pass
    upstream heroku-fcgi {
        #server 127.0.0.1:4999 max_fails=3 fail_timeout=3s;
        server unix:/tmp/heroku.fcgi.<?=getenv('PORT')?:'8080'?>.sock max_fails=3 fail_timeout=3s;
        keepalive 16;
    }
    
    server {
        # define an easy to reference name that can be used in try_files
        location @heroku-fcgi {
            include fastcgi_params;
            
            fastcgi_split_path_info ^(.+\.php)(/.*)$;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            # try_files resets $fastcgi_path_info, see http://trac.nginx.org/nginx/ticket/321, so we use the if instead
            fastcgi_param PATH_INFO $fastcgi_path_info if_not_empty;
            
            if (!-f $document_root$fastcgi_script_name) {
                # check if the script exists
                # otherwise, /foo.jpg/bar.php would get passed to FPM, which wouldn't run it as it's not in the list of allowed extensions, but this check is a good idea anyway, just in case
                return 404;
            }
            
            fastcgi_pass heroku-fcgi;
        }
        
        # TODO: use X-Forwarded-Host? http://comments.gmane.org/gmane.comp.web.nginx.english/2170
        server_name localhost;
        listen <?=getenv('PORT')?:'8080'?>;
        # FIXME: breaks redirects with foreman
        port_in_redirect off;
        
        root "<?=getenv('DOCUMENT_ROOT')?:getenv('HEROKU_APP_DIR')?:getcwd()?>";
        
        error_log stderr;
        access_log /tmp/heroku.nginx_access.<?=getenv('PORT')?:'8080'?>.log;
        
        include "<?=getenv('HEROKU_PHP_NGINX_CONFIG_INCLUDE')?>";
        
        # restrict access to hidden files, just in case
        location ~ /\. {
            deny all;
        }
		
		location / {
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-trangchu.html$ /index.php break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-LOGIN-SUCCESS.html$ /?info=success break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-CANH-BAO.html$ /?info=400 break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-LOGOUT.html$ /logout.php break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-LOGOUT-SUCCESS.html$ /?info=logout break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-CAPTCHA.html$ /system/captcha-login.php break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOT-LIKE.html$ /?chucnang=botLike break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOT-CAM-XUC.html$ /?chucnang=botReaction break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOT-COMMENT.html$ /?chucnang=botCmt break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOT-COMMENT-ANH.html$ /?chucnang=botCmtIMG break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOT-EX-LIKE.html$ /?chucnang=botExLike break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOM-LIKE.html$ /?chucnang=bomLike break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOM-WALL.html$ /?chucnang=bomWall break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOM-COMMENT.html$ /?chucnang=bomCmt break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOM-COMMENT-2.html$ /?chucnang=bomCmt2 break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOM-CAM-XUC.html$ /?chucnang=bomCamxuc break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-POST-GROUP.html$ /?chucnang=postGroup break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-POST-FRIEND.html$ /?chucnang=postFriends break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-POST-FANPAGE.html$ /?chucnang=postFanpage break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-GET-TOKEN-FANPAGE.html.html$ /?chucnang=tokenpage break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-LIKE.html$ /?chucnang=autoLike break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-XOA-STATUS.html$ /?chucnang=autoXoastt break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-DELETE-FRIEND.html$ /?chucnang=autoDelfr break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-CONFIRM-FRIEND.html$ /?chucnang=autoConfirm break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-UNFOLOW-FRIEND.html$ /?chucnang=autoUnfolow break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-INBOX-FRIEND.html$ /?chucnang=autoInbox break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-ADD-FRIEND.html$ /?chucnang=autoAddfriend break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-UNLIKE-FANPAGE.html$ /?chucnang=autoUnlikefp break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-POKE.html$ /?chucnang=autoPoke break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-COPY-STATUS.html$ /?chucnang=autoCopystt break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-UPDATE-STATUS.html$ /?chucnang=autoUpstt break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-CHECK-INFO.html$ /?chucnang=checkFriend break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-TOOL-INBOX-COUNT.html$ /?chucnang=InboxCount break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-HELP.html$ /help.html break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-ABOUT.html$ /about.html break;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-CONTACT.html$ /contact.html break;
		}


        error_page 500 /500.html;
        error_page 404 /404.html;
        error_page 403 /403.html;
        autoindex off;
		location / {
		if ($http_referer !~ "^$"){
		rewrite .*.(gif|jpg|png)$ http://www.fallingupmedia.com/wp-content/uploads/2012/01/404.jpg redirect;
		}
		}
		location /config.php {
		deny all;
		}
		
        # default handling of .php
        location ~ \.php {
            try_files @heroku-fcgi @heroku-fcgi;
        }
    }
}
