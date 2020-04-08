<div class="xmdoc">
    <ol class="breadcrumb">
        <li><a href="index.php"><{$index_module}></a></li>
        <li><a href="index.php?doc_cid=<{$category_id}>"><{$category_name}></a></li>
        <li class="active"><{$name}></li>
    </ol>
	<{if $status == 2}>
		<div class="alert alert-warning" role="alert">
			<{$smarty.const._MA_XMDOC_INFO_NEWSWAITING}>
		</div>
	<{/if}>
	<{if $status == 0}>
		<div class="alert alert-danger" role="alert">
			<{$smarty.const._MA_XMDOC_INFO_NEWSDISABLE}>
		</div>
	<{/if}>
    <div class="media">
        <div class="media-left">
			<{if $logo != ''}>
			<img class="media-object" src="<{$logo}>" alt="<{$name}>" style="max-width:150px">
			<{/if}>
        </div>
        <div class="media-body">
            <h2 class="media-heading"><{$name}></h2>
        </div>
    </div>
	<div>
		<{$description}>
	</div>
	<div class="xm-document-general-button xm-document-view">
	<a class="btn btn-primary btn" title="<{$name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$category_id}>&amp;doc_id=<{$doc_id}>" target="_blank">
		<{$smarty.const._MA_XMDOC_DOWNLOAD}>
	</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><{$smarty.const._MA_XMDOC_GENINFORMATION}></h3>
        </div>
        <div class="panel-body">
			<div class="row xm-document-view">
				<div class="col-xs-12 col-sm-6 col-md-6"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMDOC_FORMDOC_DATE}>"></span>
					<{$smarty.const._MA_XMDOC_FORMDOC_DATE}>: <{$date}>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6"><span class="glyphicon glyphicon-user" title="<{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>"></span>
					<{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>: <{$author}>
				</div>
			</div>			
			<div class="row xm-document-view">
				<{if $mdate}>
				<div class="col-xs-12 col-sm-6 col-md-6"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>"></span>
					<{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>: <{$mdate}>
				</div>
				<{/if}>
				<{if $size != ''}>
				<div class="col-xs-12 col-sm-6 col-md-6"><span class="glyphicon glyphicon-resize-full" title="<{$smarty.const._MA_XMDOC_FORMDOC_SIZE}>"></span>
					<{$smarty.const._MA_XMDOC_FORMDOC_SIZE}>: <{$size}>
				</div>
				<{/if}>
			</div>
			<div class="row xm-document-view">
				<div class="col-xs-12 col-sm-6 col-md-6"><span class="glyphicon glyphicon-download-alt" title="<{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}>"></span>
					<{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}>: <{$counter}>
				</div>
				<{if $dorating == 1}>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<{include file="db:xmsocial_rating.tpl" down_xmsocial=$xmsocial_arr}>
				</div>
				<{/if}>
			</div>
			<div class="xm-document-general-button">
				<div class="btn-group" role="group">
					<{if $perm_edit == true}>
                    <a href="action.php?op=edit&amp;document_id=<{$doc_id}>">
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> <{$smarty.const._MA_XMDOC_EDIT}></button>
                    </a>
					<{/if}>
					<{if $perm_del == true}>
                    <a href="action.php?op=del&amp;document_id=<{$doc_id}>">
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> <{$smarty.const._MA_XMDOC_DEL}></button>
                    </a>
					<{/if}>
				</div>
			</div>
			
        </div>
    </div>
</div><!-- .xmdoc -->