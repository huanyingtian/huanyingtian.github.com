<?php exit(); ?>
# Helicon ISAPI_Rewrite configuration file
# Version 3.1.0.87
RewriteEngine on

ErrorDocument 404 /404.html
RewriteRule ^(.*)product$   	 $1product/ [L,R=301]
RewriteRule ^(.*)sitemap$   	 $1sitemap/ [L,R=301]
RewriteRule ^(.*)news$   	 $1news/ [L,R=301]
RewriteRule ^(.*)case$   	 $1case/ [L,R=301]
RewriteRule ^(.*)about$  	 $1about/ [L,R=301]
RewriteRule ^(.*)job$  		 $1job/ [L,R=301]
RewriteRule ^(.*)download$  	 $1download/ [L,R=301]
RewriteRule ^(.*)message$   	 $1message/ [L,R=301]
RewriteRule ^(.*)blog$   	 $1blog/ [L,R=301]

RewriteRule ^(.*)product\/([A-Za-z0-9]+)$   		$1product/$2/ [L,R=301]
RewriteRule ^(.*)news\/([A-Za-z0-9]+)$   		$1news/$2/ [L,R=301]
RewriteRule ^(.*)case\/([A-Za-z0-9]+)$   		$1case/$2/ [L,R=301]
RewriteRule ^(.*)download\/([0-9]+)$   			$1download/$2/ [L,R=301]
RewriteRule ^(.*)job\/([0-9]+)$   				$1job/$2/ [L,R=301]

# URL路由方式
RewriteRule ^index\.html$                               index.php [L]
RewriteRule ^([A-Za-z]+)\.html$                         index.php?city=$1 [L]
RewriteRule ^sitemap\.xml$                               wzmap.php [L]

RewriteRule ^index\.html$                               index.php [L]
RewriteRule ^sitemap\/$                                 sitemap.php [L]
RewriteRule ^message\/$                          		message.php [L]
RewriteRule ^news\/$                                    news.php [L]
RewriteRule ^case\/$                                    case.php [L]
RewriteRule ^blog\/$                                    blog.php [L]
RewriteRule ^product\/$                                 product.php [L]
RewriteRule ^download\/$                            	download.php [L]
RewriteRule ^job\/$                                 	job.php [L]

RewriteRule ^product\/([0-9]+)\.html$                   product.php?mod=detail&id=$1 [L]

RewriteRule ^product\/([0-9]+)_([A-Za-z]+)\.html$       product.php?mod=detail&id=$1&svc=$2 [L]

RewriteRule ^product\/([A-Za-z]+)_([0-9]+)\.html$       product.php?mod=detail&id=$2&city=$1 [L]
RewriteRule ^product\/([A-Za-z]+)_([A-Za-z0-9]+)\/$     product.php?mod=list&city=$1&word=$2 [L]

RewriteRule ^product\/([A-Za-z0-9]+)\/$                 product.php?mod=list&word=$1 [L]
RewriteRule ^product\/([A-Za-z0-9]+)\/p([0-9]+)\.html$  product.php?mod=list&word=$1&page=$2 [L]
RewriteRule ^product\/p([0-9]+)\.html$                  product.php?mod=list&page=$1 [L]

RewriteRule ^about\/$						about.php [L]
RewriteRule ^about\/([A-Za-z0-9]+)\.html$			about.php?word=$1 [L]
RewriteRule ^about\/([A-Za-z0-9]+)_([0-9]+)\.html$			about.php?word=$1&pagenum=$2 [L]
RewriteRule ^about_([A-Za-z0-9_]+)\/$				about.php?catdir=$1 [L]
RewriteRule ^about_([A-Za-z0-9_]+)\/([A-Za-z0-9_]+)\.html$	about.php?catdir=$1&word=$2 [L]
RewriteRule ^about_([A-Za-z0-9_]+)\/([A-Za-z0-9_]+)_([0-9]+)\.html$	about.php?catdir=$1&word=$2&pagenum=$3 [L]


RewriteRule ^news\/([0-9]+)\.html$                   	news.php?mod=detail&id=$1 [L]
RewriteRule ^news\/([A-Za-z0-9]+)\/$                    news.php?mod=list&word=$1 [L]
RewriteRule ^news\/([A-Za-z0-9]+)\/p([0-9]+)\.html$     news.php?mod=list&word=$1&page=$2 [L]
RewriteRule ^news\/p([0-9]+)\.html$                     news.php?mod=list&page=$1 [L]


RewriteRule ^case\/([0-9]+)\.html$                   	case.php?mod=detail&id=$1 [L]
RewriteRule ^case\/([A-Za-z0-9]+)\/$                    case.php?mod=list&word=$1 [L]
RewriteRule ^case\/([A-Za-z0-9]+)\/p([0-9]+)\.html$     case.php?mod=list&word=$1&page=$2 [L]
RewriteRule ^case\/p([0-9]+)\.html$                     case.php?mod=list&page=$1 [L]

RewriteRule ^tag\/(.*)$                    				tag.php?tag=$1 [L]

RewriteRule ^blog\/([0-9]+)\.html$                   	blog.php?mod=detail&id=$1 [L]
RewriteRule ^blog\/p([0-9]+)\.html$                     blog.php?mod=list&page=$1 [L]

RewriteRule ^job\/([0-9]+)\.html$                   	job.php?mod=detail&id=$1 [L]
RewriteRule ^job\/([A-Za-z0-9]+)\/$                     job.php?mod=list&cid=$1 [L]
RewriteRule ^job\/p([0-9]+)\.html$                   	job.php?mod=list&page=$1 [L]
RewriteRule ^job\/([0-9]+)\/p([0-9]+)\.html$          	job.php?mod=list&cid=$1&page=$2 [L]

RewriteRule ^download\/([0-9]+)\.html$                  download.php?mod=detail&id=$1 [L]
RewriteRule ^download\/([A-Za-z0-9]+)\/$                download.php?mod=list&cid=$1 [L]
RewriteRule ^download\/p([0-9]+)\.html$                 download.php?mod=list&page=$1 [L]
RewriteRule ^download\/([0-9]+)\/p([0-9]+)\.html$       download.php?mod=list&cid=$1&page=$2 [L]

RewriteRule ^region\/$                              		region.php [L]


# 手机端路由地址
RewriteRule ^m/product_detail\/([0-9]+)\.html$                   m/product_detail.php?id=$1 [L]
RewriteRule ^m/news\/([0-9]+)\.html$                   m/news_detail.php?id=$1 [L]
RewriteRule ^m/product\/([A-Za-z0-9]+)\/$                    m/product.php?mod=$1 [L]
RewriteRule ^m/products\/$                    m/product_list.php?[L]
RewriteRule ^m/news\/$                    m/news_sort.php?[L]
RewriteRule ^m/news\/([A-Za-z0-9]+)\/$                    m/news_list.php?mod=$1 [L]
RewriteRule ^m/about_mobile\/([A-Zm_a-z0-9]+)\.html$                    m/single_page.php?mod=$1 [L]
RewriteRule ^m/message\/$                    m/message.php?[L]