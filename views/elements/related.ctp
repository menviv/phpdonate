<div class="relatedArticle left">
	<div class="relatedArticleTop">באותו עניין</div>
	<div class="relatedArticleTitle"><?php echo $html->link($related['Article']['title'],"/".$related['Article']['link']);?></div>
	<div class="relatedArticleSummary"><?php echo strip_tags($related['Article']['description']);?> <?php echo $html->link("קרא עוד »","/".$related['Article']['link']);?></div>
</div>