<{if $index_header}>
    <div class="row">
        <div class="col-sm-12" style="padding-bottom: 10px; padding-top: 5px;">
            <{$index_header}>
        </div>
    </div>
<{/if}>
<{if $filter}>
	<ol class="breadcrumb">
		<li class="active"><{$smarty.const._MA_XMDOC_HOME}></li>
	</ol>
	<div align="center">
		<form class="form-inline" id="form_news_tri" name="form_news_tri" method="get" action="index.php">
			<div class="form-group">
				<label><{$smarty.const._MA_XMDOC_INDEX_SELECTCATEGORY}></label>
				<select class="form-control" name="news_filter" id="news_filter" onchange="location='index.php?doc_cid='+this.options[this.selectedIndex].value">
					<{$doc_cid_options}>
				<select>
			</div>
		</form>
	</div>
	<br>		
	<br>
<{else}>
	<ol class="breadcrumb">
		<li><a href="index.php"><{$smarty.const._MA_XMDOC_HOME}></a></li>
		<li class="active"><{$category_name}></li>
	</ol>
	<div class="media">
		<div class="media-left">
			<{if $category_logo != ''}>
			<img class="media-object" src="<{$category_logo}>" alt="<{$category_name}>" style="max-width:150px">
			<{/if}>
		</div>
		<div class="media-body">
			<h2 class="media-heading"><{$category_name}></h2>
			<{$category_description}>
		</div>
	</div>
	<br>		
	<br>		
<{/if}>
<{if $document_count != 0}>
	<{foreach item=document from=$documents}>
		<{if $index_column == 1}>
			<div class="xm-document">
				<div class="col-sm-12 col-md-12 xm-minibox">
					<div class="xm-document-logo">
						<img src="<{$document.logo}>" alt="<{$document.name}>">
					</div>
					<a class="xm-document-title" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
						<{$document.name}>
					</a>
					<div class="xm-document-description">
						<{$document.description_short|truncateHtml:10:'...'}>
					</div>
					<div class="xm-document-view">
						<button type="button" class="btn btn-default btn-xs glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#myModal<{$document.id}>"></button>
					</div>
					<a class="btn btn-primary btn-xs col-md-9" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
						<{$smarty.const._MA_XMDOC_DOWNLOAD}>
					</a>
				</div>				
			</div>
		<{/if}>
		<{if $index_column == 2}>
			<{if $document.row == true}>
				<div class="row xm-document">
			<{/if}>
			<div class="col-sm-6 col-md-6 xm-minibox">
				<div class="xm-document-logo">
					<img src="<{$document.logo}>" alt="<{$document.name}>">
				</div>
				<a class="xm-document-title" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
					<{$document.name}>
				</a>
				<div class="xm-document-description">
					<{$document.description_short|truncateHtml:10:'...'}>
				</div>
				<div class="xm-document-view">
					<button type="button" class="btn btn-default btn-xs glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#myModal<{$document.id}>"></button>
				</div>
				<a class="btn btn-primary btn-xs col-md-9" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
					<{$smarty.const._MA_XMDOC_DOWNLOAD}>
				</a>
			</div>	
			<{if $document.count is div by $index_column || $document.end == true}>
				</div>
			<{/if}>
		<{/if}>
		<{if $index_column == 3}>
			<{if $document.row == true}>
				<div class="row xm-document">
			<{/if}>
			<div class="col-sm-4 col-md-4 xm-minibox">
				<div class="xm-document-logo">
					<img src="<{$document.logo}>" alt="<{$document.name}>">
				</div>
				<a class="xm-document-title" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
					<{$document.name}>
				</a>
				<div class="xm-document-description">
					<{$document.description_short|truncateHtml:10:'...'}>
				</div>
				<div class="xm-document-view">
					<button type="button" class="btn btn-default btn-xs glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#myModal<{$document.id}>"></button>
				</div>
				<a class="btn btn-primary btn-xs col-md-9" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
					<{$smarty.const._MA_XMDOC_DOWNLOAD}>
				</a>
			</div>	
			<{if $document.count is div by $index_column || $document.end == true}>
				</div>
			<{/if}>
		<{/if}>
		<{if $index_column == 4}>
			<{if $document.row == true}>
				<div class="row xm-document">
			<{/if}>
			<div class="col-sm-3 col-md-3 xm-minibox">
				<div class="xm-document-logo">
					<img src="<{$document.logo}>" alt="<{$document.name}>">
				</div>
				<a class="xm-document-title" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
					<{$document.name}>
				</a>
				<div class="xm-document-description">
					<{$document.description_short|truncateHtml:10:'...'}>
				</div>
				<div class="xm-document-view">
					<button type="button" class="btn btn-default btn-xs glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#myModal<{$document.id}>"></button>
				</div>
				<a class="btn btn-primary btn-xs col-md-9" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
					<{$smarty.const._MA_XMDOC_DOWNLOAD}>
				</a>
			</div>	
			<{if $document.count is div by $index_column || $document.end == true}>
				</div>
			<{/if}>
		<{/if}>
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
										<div class="col-md-6"><span class="glyphicon glyphicon-user" title="<{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>"></span>
											<{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>: <{$document.author}>
										</div>
									</div>
									<{if $document.mdate}>
									<div class="row xm-document-view">
										<div class="col-md-12"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>"></span>
											<{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>: <{$document.mdate}>
										</div>
									</div>
									<{/if}>
									<{if $document.size != ''}>
									<div class="row xm-document-view">
										<div class="col-md-12"><span class="glyphicon glyphicon-resize-full" title="<{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>"></span>
											<{$smarty.const._MA_XMDOC_FORMDOC_SIZE}>: <{$document.size}>
										</div>
									</div>
									<{/if}>
									<div class="row xm-document-view">
										<div class="col-md-6"><span class="glyphicon glyphicon-download-alt" title="<{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}>"></span>
											<{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}>: <{$document.counter}>
										</div>
										<div class="col-md-6"><span class="glyphicon glyphicon-star-empty" title="<{$smarty.const._MA_XMDOC_FORMDOC_RATING}>"></span>
											<{$smarty.const._MA_XMDOC_FORMDOC_RATING}>: <{$document.rating}> <{$document.votes}>
										</div>
									</div>
									<div class="xm-document-general-button">
										<div class="btn-group" role="group" aria-label="...">
											<{if $document.perm_edit == true}>
											<a href="<{$xoops_url}>/modules/xmdoc/action.php?op=edit&amp;document_id=<{$document.id}>">
												<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> <{$smarty.const._MA_XMDOC_EDIT}></button>
											</a>
											<{/if}>
											<{if $document.perm_del == true}>
											<a href="<{$xoops_url}>/modules/xmdoc/action.php?op=del&amp;document_id=<{$document.id}>">
												<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> <{$smarty.const._MA_XMDOC_DEL}></button>
											</a>
											<{/if}>
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
	<{if $nav_menu}>
		<div class="row">
			<div class="col-sm-12" style="padding-bottom: 10px; padding-top: 5px; padding-right: 60px; text-align: right;">
				<{$nav_menu}>
			</div>
		</div>
	<{/if}>
<{else}>
<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<{$smarty.const._MA_XMDOC_ERROR_NODOCUMENT}>
</div>
<{/if}>

<{if $index_footer}>
    <div class="row" style="padding-bottom: 5px; padding-top: 5px;">
        <div class="col-sm-12">
            <{$index_footer}>
        </div>
    </div>
<{/if}>
