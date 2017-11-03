<ul class="sort">
  <!--{foreach $productTreeCate as $volist}-->
  	<li>
      <a href="<!--{$volist.url}-->" class="a"><!--{$volist.cname}--></a>
      <div class="sec">
      	<ul>
        	<!--{foreach $volist.childcategory as $seclist}-->
         	  <li><a href="<!--{$seclist.url}-->" class="b"><!--{$seclist.cname}--></a></li>
            <!--{/foreach}-->
        </ul>
      </div>
    </li>
  <!--{/foreach}-->   
</ul>