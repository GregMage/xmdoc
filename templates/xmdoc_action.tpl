<div class="xmdoc">
    <{if $category_count gt 0}>
        <ol class="breadcrumb">
            <li class="active"><{$smarty.const._MA_XMDOC_SELECTCATEGORY}></li>
        </ol>
		<div class="xm-category row">
			<{foreach item=category from=$categories}>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 xm-category-list">
					<a class="btn btn-primary btn-md btn-block" title="<{$category.name}>"
					   href="<{$xoops_url}>/modules/xmdoc/action.php?op=loaddocument&category_id=<{$category.id}>">
						<{$category.name}>
					</a>

					<a title="<{$category.name}>" href="<{$xoops_url}>/modules/xmdoc/action.php?op=loaddocument&category_id=<{$category.id}>" class="xm-category-image">
						<img src="<{$category.logo}>" alt="<{$category.name}>">
					</a>

					<!-- Category Description -->
					<div class="aligncenter">
						<{if $category.description != ""}>
							<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#xmDesc-<{$category.id}>">+</button>
						<{else}>
							<button class="btn btn-xs disabled" data-toggle="modal">+</button>
						<{/if}>
					</div>

					<div class="modal fade" id="xmDesc-<{$category.id}>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header"><h4 class="modal-title aligncenter"><{$category.name}></h4></div>
								<div class="modal-body">
									<{$category.description}>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
								</div>
							</div>
						</div>
					</div>
					<!-- End Category Description -->
				</div>
				<!-- .xm-category-list -->
			<{/foreach}>
		</div><!-- .xm-category -->
		<div class="clear spacer"></div>
		<{if $nav_menu}>
			<div class="floatright"><{$nav_menu}></div>
			<div class="clear spacer"></div>
		<{/if}>
    <{/if}>
	<{if $error_message != ''}>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<{$error_message}>
		</div>
	<{/if}>    

	<{if $form}>
        <ol class="breadcrumb">
            <li><a href="action.php?op=add"><{$smarty.const._MA_XMDOC_SELECTCATEGORY}></a></li>
            <li class="active"><{$smarty.const._MA_XMDOC_ADD}></li>
        </ol>
        <{if $tips != ''}>
            <div class="alert alert-info alert-dismissible" role="alert">
                <div class="floatleft">
                    <h4><{$smarty.const._MA_XMDOC_DOCUMENT_DOCUMENT}></h4>
                    <ul>
                        <li><{$smarty.const._MA_XMDOC_CATEGORY_SIZE}>: <{$size}></li>
                        <li><{$smarty.const._MA_XMDOC_CATEGORY_EXTENSION}>: <{$extensions}></li>
                    </ul>        
                </div>
                <div class="clear">&nbsp;</div>
            </div>
        <{/if}>
		<div>
			<{$form}>
		</div>
	<{/if}>
</div><!-- .xmdoc-->