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

    gzip on;

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
		
		#Ngan site khac su dung hinh anh cua site minh
		location ~ .(gif|png|jpe?g)$ {
		valid_referers none blocked .domain.com;
		if ($invalid_referer) {
		return   403;
		}
		}
		
		#Su dung browser caching
		location ~* \.(?:ico|css|js|jpe?g|png|gif|svg|pdf|mov|mp4|mp3|woff)$ {
        expires 7d;
        add_header Pragma public;
        add_header Cache-Control "public";
        gzip_vary on;
        }

		#Cac quy tac cho site Bot.Vn
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-trangchu.html$ /index.php last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-LOGIN-SUCCESS.html$ /?info=success last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-CANH-BAO.html$ /?info=400 last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-SMS.html$ /?info=thongbao last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-LOGOUT.html$ /logout.php last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-LOGOUT-SUCCESS.html$ /?info=logout last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-CAPTCHA.html$ /system/captcha-login.php last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOT-LIKE.html$ /?chucnang=botLike last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOT-CAM-XUC.html$ /?chucnang=botReaction last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOT-COMMENT.html$ /?chucnang=botCmt last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOT-COMMENT-ANH.html$ /?chucnang=botCmtIMG last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOT-EX-LIKE.html$ /?chucnang=botExLike last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOM-LIKE.html$ /?chucnang=bomLike last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOM-WALL.html$ /?chucnang=bomWall last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOM-COMMENT.html$ /?chucnang=bomCmt last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOM-COMMENT-2.html$ /?chucnang=bomCmt2 last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-BOM-CAM-XUC.html$ /?chucnang=bomCamxuc last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-POST-GROUP.html$ /?chucnang=postGroup last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-POST-FRIEND.html$ /?chucnang=postFriends last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-POST-FANPAGE.html$ /?chucnang=postFanpage last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-GET-TOKEN-FANPAGE.html.html$ /?chucnang=tokenpage last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-LIKE.html$ /?chucnang=autoLike last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-XOA-STATUS.html$ /?chucnang=autoXoastt last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-DELETE-FRIEND.html$ /?chucnang=autoDelfr last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-CONFIRM-FRIEND.html$ /?chucnang=autoConfirm last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-UNFOLOW-FRIEND.html$ /?chucnang=autoUnfolow last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-INBOX-FRIEND.html$ /?chucnang=autoInbox last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-ADD-FRIEND.html$ /?chucnang=autoAddfriend last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-UNLIKE-FANPAGE.html$ /?chucnang=autoUnlikefp last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-POKE.html$ /?chucnang=autoPoke last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-COPY-STATUS.html$ /?chucnang=autoCopystt last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-UPDATE-STATUS.html$ /?chucnang=autoUpstt last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-AUTO-CHECK-INFO.html$ /?chucnang=checkFriend last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-TOOL-INBOX-COUNT.html$ /?chucnang=InboxCount last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-HELP.html$ /help.html last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-ABOUT.html$ /about.html last;
		rewrite ^/BOTVN-AUTO-AND-BOT-LIKE-FACEBOOK-CONTACT.html$ /contact.html last;

		#Chuyen huong loi
        #error_page 500 /500.html;
        #error_page 404 /404.html;
        #error_page 403 /403.html;
		
        # default handling of .php
        location ~ \.php {
            try_files @heroku-fcgi @heroku-fcgi;
        }
    }

}
