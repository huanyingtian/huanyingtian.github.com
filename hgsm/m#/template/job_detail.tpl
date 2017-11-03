<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="product_content">
    <div class="content jobcontent">
        <h4>岗位名称</h4>
        <div class="text"><!--{$single_job.title}--></div>
        <h4>岗位职责</h4>
        <div class="text"><!--{$single_job.jobdescription}--></div>
        <h4>职位要求</h4>
        <div class="text"><!--{$single_job.jobrequest}--></div>
        <!--{if $single_job.jobotherrequest!=""}-->
            <h4>其他要求</h4>
            <div class="text"> <!--{$single_job.jobotherrequest}--></div>
        <!--{/if}-->
        <h4>工作地点</h4>
        <div class="text"><!--{$single_job.workarea}--></div>
        <h4>招聘人数</h4>
        <div class="text"><!--{$single_job.number}--></div>
        <h4>招聘负责人联系方式</h4>
        <div class="text"><!--{$single_job.jobcontact}--></div>
    </div>
    <!--{$shang}-->
</div>
<!--{/block}-->