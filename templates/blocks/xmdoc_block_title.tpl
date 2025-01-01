<{if $block.document|default:'' != ''}>
	<ul class="list-group list-group-flush">
		<{foreach item=blocdocument from=$block.document}>
			<{if $block.type != 4}>
			<a class="list-group-item list-group-item-action p-1 text-truncate" title="<{$blocdocument.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$blocdocument.categoryid}>&doc_id=<{$blocdocument.id}>">
			<{else}>
			<a class="list-group-item list-group-item-action p-1 text-truncate" title="<{$blocdocument.name}>" href="<{$xoops_url}>/modules/xmdoc/action.php?op=edit&document_id=<{$blocdocument.id}>">
			<{/if}>
				<{if $block.logo == true}>
					<{if $blocdocument.logo != ''}>
						<img src="<{$blocdocument.logo}>" alt="<{$blocdocument.name}>" style="max-width:<{$block.size}>px" class="rounded">
					<{/if}>
				<{/if}>
				<{$blocdocument.name}>
			</a>
		<{/foreach}>
	</ul>
<{/if}>
