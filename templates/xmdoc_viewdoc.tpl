<{if $xmdoc_viewdocs == true}>
    <{foreach item=document from=$document}>
        <div class="col-sm-4 col-md-4 xm-minibox">
            <div class="xm-document-logo">
                <img src="<{$document.logo}>" alt="<{$document.name}>">
            </div>
            <a class="xm-document-title" title="<{$document.name}>" href="">
                <{$document.name}>
            </a>

            <div class="xm-document-description">
                <{$document.description_short}> <button type="button" class="btn btn-default btn-xs glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#myModal<{$document.id}>"></button>
            </div>
            <a class="btn btn-primary btn-xs col-md-9" title="<{$document.name}>" href="">
                <{$smarty.const._MA_XMDOC_DOWNLOAD}>
            </a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal<{$document.id}>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><{$document.name}></h4>
                    </div>
                    <div class="modal-body">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="<{$document.logo}>" alt="<{$document.name}>">
                                </a>
                            </div>
                            <div class="media-body">
                                <{$document.description}>
                                <{if $document.showinfo == 1}>
                                <div class="xm-document-view-top">
                                    <div class="row xm-document-view">
                                        <div class="col-md-6"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMDOC_FORMDOC_DATE}>"></span>
                                            <{$smarty.const._MA_XMDOC_FORMDOC_DATE}>: <{$document.date}>
                                        </div>
                                        <div class="col-md-6"><span class="glyphicon glyphicon-user" title="<{$smarty.const._MA_XMARTICLE_AUTHOR}>"></span>
                                            <{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>: <{$document.author}>
                                        </div>
                                    </div>
                                    <{if $document.mdate}>
                                    <div class="row xm-document-view">
                                        <div class="col-md-6"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMARTICLE_MDATE}>"></span>
                                            <{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>: <{$document.mdate}>
                                        </div>
                                    </div>
                                    <{/if}>
                                    <div class="row xm-document-view">
                                        <div class="col-md-6"><span class="glyphicon glyphicon-download-alt" title="<{$smarty.const._MA_XMARTICLE_DATE}>"></span>
                                            <{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}>: <{$document.counter}>
                                        </div>
                                        <div class="col-md-6"><span class="glyphicon glyphicon-star-empty" title="<{$smarty.const._MA_XMARTICLE_DATE}>"></span>
                                            <{$smarty.const._MA_XMDOC_FORMDOC_RATING}>: <{$document.rating}> <{$document.votes}>
                                        </div>
                                    </div>
                                </div>
                                <{/if}>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><{$smarty.const._CLOSE}></button>
                    </div>
                </div>
            </div>
        </div>
    <{/foreach}>
<{/if}>
<!-- .xmdoc -->