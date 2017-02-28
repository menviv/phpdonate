<?php echo $this->element("sideRight");?>
<div id="staffPage" class="leftSideSmall right">
	<div id="mainarticlePageTopTitle"><?php echo $currentPageData['Page']['pname'];?></div>
	<div id="pageShareLinks">
		<?php echo $this->element("shareRow");?>
		<div class="both"></div>
	</div>
	<div class="pageShareLinksSep"></div>
	<div id="staffContainer">
		<div id="staffBg" class="png"></div>
		<div id="staffImages">
			<div id="staffImagesBg"></div>
			<div id="staffImagesInner">
				<?php $counter=1;?>
				<?php foreach($staff as $item):?>
					<div class="staffImage staffImage<?php echo $counter;?>" id="staffImage<?php echo $item['Staff']['position'];?>"><a href="javascript:void(0);" onclick="changeStaff('<?php echo $item['Staff']['position'];?>','<?php echo $counter;?>')"><?php echo $html->image("uploads/staff/".$item['Staff']['thumb']);?></a></div>
					<?php $counter++;?>
				<?php endforeach;?>
			</div>
		</div>
		<div id="staffBodies">
			<div id="staffBodiesBg"></div>
			<div id="staffBodiesMan"></div>
			<div id="staffBodiesWoman" style="display:none;"></div>
			<div id="staffBodiesInner">
				<?php $counter=1;?>
				<?php foreach($staff as $item):?>
					<div class="staffBody<?php if($counter==1) echo " staffBodyCurrent";?>" id="staffBody<?php echo $item['Staff']['position'];?>"><?php echo $html->image("uploads/staff/".$item['Staff']['head']);?></div>
					<?php $counter++;?>
				<?php endforeach;?>
			</div>
		</div>
		<div id="staffContent">
			<?php $counter=1;?>
			<?php foreach($staff as $item):?>
				<div class="staffContentItem<?php if($counter==1)echo " staffContentItemCurrent";?>" id="staffContentItem<?php echo $counter;?>">
					<div class="staffContentTop"></div>
					<div class="staffContentInner">
						<div class="staffContentTitle"><?php echo $item['Staff']['name'];?></div>
						<div class="staffContentJob"><?php echo $item['Staff']['job'];?></div>
						<div class="staffContentText"><?php echo $item['Staff']['text'];?></div>
					</div>
				</div>
				<?php $counter++;?>
			<?php endforeach;?>
		</div>
	</div>
</div>
<div class="both"></div>
<script type="text/javascript">
	staffJson = <?php echo json_encode($staff);?>;
	//$$('.staffImage').invoke('observe', 'mouseover', staffOver).invoke('observe', 'mouseout', staffOut);
	$j(document).ready(function(){
		eleTip = $j("#staffTooltip");
		$j(".staffImage").tooltip({offset: [75,0],tip:eleTip,predelay:100,onBeforeShow:function(event){
			var element = event.originalTarget || event.srcElement;
			parent = $j(element).closest(".staffImage")[0];
			num = parseInt($j(parent).attr("class").replace(/staffImage/gi,""));
			$("staffTooltipBodyName").innerHTML = staffJson[num-1]['Staff']['name'];
			$("staffTooltipBodyText").innerHTML = staffJson[num-1]['Staff']['job'];
		}});
	});
</script>