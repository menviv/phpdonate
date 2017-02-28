<rss version="2.0">
	<channel>
		<title>הוועד למלחמה באיידס</title>
		<link><?php echo "http://".$_SERVER['HTTP_HOST'].$this->base."/";?></link>
		<description>הוועד למלחמה באיידס</description>
		<language>he</language>
		<pubDate><?php echo date("D, j M Y H:i:s", gmmktime()) . ' GMT';?></pubDate>
		<?php foreach($items as $item):?>
			<item>
				<title><?php echo $item['Page']['pname'];?></title>
				<link><?php echo "http://".$_SERVER['HTTP_HOST'].$this->base."/".$item['Page']['link']; ?></link>
				<description><![CDATA[<?php echo $this->maxchars($item['Page']['content'],500);?>]]></description>
				<pubDate><?php echo $time->nice($time->gmt($item['Page']['dateAdd'])) . ' GMT'; ?></pubDate>
				<guid><?php echo "http://".$_SERVER['HTTP_HOST'].$this->base."/".$item['Page']['link']; ?></guid>
			</item>
		<?php endforeach;?>
	</channel>
</rss>