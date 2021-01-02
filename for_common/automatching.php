<?php

include_once('./_common.php');

$outer_css=' automaching ';

$bg_type = "sub";
add_javascript('<script src="'.G5_THEME_URL.'/extend/clipboard.min.js"></script>', 1);
include_once('../_head.php');

$mrpoint=get_mempoint($member[mb_id], $member[mb_id]);
$isum=get_itemsum($member[mb_id]);

$acc_sql = "select *,sum(case when ac_id like '%.%' then 1 end) max, sum(ac_auto_a) cnt_a,sum(ac_auto_b) cnt_b,sum(ac_auto_c) cnt_c from  {$g5['cn_sub_account']} where mb_id='$member[mb_id]' order by ac_id asc limit 1";
$acc_row = sql_fetch($acc_sql);
?>
<div id="Contents" class="sub_con">
    

	<div class="wrap">
		<div class="main_top_box">
			<p  style="position:relative">골드 : <?=number_format2($rpoint['i']['_enable'])?> </p>
		</div>
	</div>
	<div class="wrap">
		<div class="main_top_box">
			<ul class="mem_list">
				<?php
				foreach ($g5['cn_item'] as $k=>$v) {?>
					<li class="mem_bx">
					<input type='hidden' name='w' value='al' >
						<div class="mtp">
							<div class="img">
								<img src="<?=G5_THEME_URL?>/images/item/<?=$v[img]?>" alt="" />
							</div>
							<div class="txt">
								<h4><?=$v[name_kr]?></h4>
								
								보유기간<?=$v[days]?>일 이율<?=$v[interest]?>%<br />
								<span class="c_pink">$<?=$v[price]?> ~ $<?=$v[mxprice]?></span>
							</div>
						</div>
						<ul class="msct">
							<li class="">
								<div class="t">수량</div>
								<div class="c">
									<input type="text" name="" class="ipt_num" id="cnt_<?=$k?>" value="<?=$acc_row["cnt_{$k}"]?>" />
									<div class="ipt_arw">
										<div class="up"><button type="button" onclick="fn_controller('<?=$k?>','up','<?=$v[price]?>')"><img src="<?=G5_THEME_URL?>/new_img/ic_up.png" /></button></div>
										<div class="dw"><button type="button" onclick="fn_controller('<?=$k?>','down','<?=$v[price]?>')"><img src="<?=G5_THEME_URL?>/new_img/ic_down.png" /></button></div>
									</div>
								</div>
								<div class="t">소요골드</div>
								<div class="c">
									<input type="text" name="" style="width:100%" readonly=true class="ipt_num" id="price_<?=$k?>" value="<?=$v[price]*$acc_row["cnt_{$k}"]?>" />
								</div>
							</li>
							<button type="button" onclick="schedule_buy('<?=$k?>');" name="" class="ipt_submit"><img src="<?=G5_THEME_URL?>/new_img/btn_finish.png" /></button>
						</ul>
					</li>
				<?php
				}?>
			</ul>
		</div>
	</div>
</div>
<script>
function fn_controller($obj,$fn,$price){
	var $cnt_obj = $("#cnt_"+$obj);
	var $price_label = $("#price_"+$obj);
	var $obj_val = $cnt_obj.val();
	var $max = <?=$acc_row['max']>0?$acc_row['max']:0?>;
	if($fn=='up'){
		if($obj_val>=10){
		 return false;	
		}
		$obj_val++;
	}else
	if($fn=='down'){
		if($obj_val>0){
			$obj_val--;
		}
	}else
	if($fn=='del'){
		$obj_val = 0;
	}
	$cnt_obj.val($obj_val);
	$price_label.val($obj_val*$price);

}

function schedule_buy($k){
	var itemCnt = $("#cnt_"+$k).val();
	if(itemCnt<=0){
		alert("아이템은 0개 이상만 가능합니다.");
		return;
	}
	var itemPrice = $("#price_"+$k).val();
	var formData = {"w":"new","cnt":itemCnt,"price":itemPrice,"type":$k};
	$.ajax({
		type: "POST",
		url: "./automatching.update.php",
		data:formData,
		cache: false,
		async: false,
		dataType:"json",
		success: function(data) {
		}
	});
}
</script>
<div style="width:100%;height:100%;position:fixed;top:0;left:0;z-index:10;background:#00000094;display:none" id="process_overlay">
	<div style="top:50%;left:0;width:100%;position:fixed;text-align:center">
		처리중입니다.
	</div>
</div>
<?php
include_once('../_tail.php');
?>
<style>
.mem_list{padding-bottom:3em;}
.mem_list li{overflow:hidden; margin-bottom:1em;}
.mem_list li.mem_bx{/*border-radius:2em; border:2px solid #edeadb; box-shadow: 2px 2px 3px 0 #523e01;background:#FFF url(../images/mem_bg.png) no-repeat 0 0; background-size:100% 100%;*/}
.mem_list li.mem_bx .mtp,
.mem_list li.mem_bx .mbt{overflow:hidden; padding:1em; overflow:hidden;}
.mem_list li.mem_bx .mtp {display:Table;}
.mem_list li.mem_bx .mtp > div{display:table-cell; vertical-align:middle;}
.mem_list li.mem_bx .mtp .img{width:25%; }
.mem_list li.mem_bx .mtp .img img{width:100%}
.mem_list li.mem_bx .mtp .txt{width:75%;padding-left:20px;color:#86521f;font-weight:bold;text-align: left;color:#fff}
.mem_list li.mem_bx .mtp .txt h4 {padding-bottom:10px}
.mem_list li.mem_bx:nth-child(1) .mtp .txt,.mem_list li.mem_bx:nth-child(1) .mtp .txt h4{color:#fff}
.mem_list li.mem_bx:nth-child(2) .mtp .txt,.mem_list li.mem_bx:nth-child(2) .mtp .txt h4{color:#ffff00}
.mem_list li.mem_bx:nth-child(3) .mtp .txt,.mem_list li.mem_bx:nth-child(3) .mtp .txt h4{color:#fc687d}

.mem_list li.mem_bx .mbt{background:#f7eacf;}
.mem_list li.mem_bx .mbt .t{color:#2e2e2e; font-size:1.2em; font-weight:bold; margin-bottom:5px;}
.mem_list li.mem_bx .mbt .c{overflow:hidden;}
.mem_list li.mem_bx .mbt .c .ipt_txt {width:calc(100% - 100px); font-family:'HeirofLight'; margin-right:10px; float:left; border-radius:10px; height:40px; line-height:40px; padding:0 10px; background:#cdcdcd; border:0; }
.mem_list li.mem_bx .mbt .c .ipt_btn {width:90px; /*height:40px; font-family:'HeirofLight'; float:left; font-size:1.2em; font-weight:bold; color:#254928; padding:7px 0px; border-radius: 50px; overflow:hidden; background-color:#51a14d; background-repeat:no-repeat; background-size:100% 100%; background-position: 0 0;text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff; border:0;*/ }
.mem_list li.mem_bx .mbt .c .ipt_btn img{width:100%}
.mem_list li.mem_bx .mbt .s {font-size:0.85em; margin-top:10px;}
.mem_list li.mem_bx .mbt .s span {font-family:'Noto Sans KR', '돋움', '돋음', 'Dotum', 'Baekmuk Dotum', 'Undotum', 'Apple Gothic', 'Latin font', sans-serif;}

.mem_list li.mem_bx .msct {position: relative; font-weight:bold;}
.mem_list li.mem_bx .msct li{overflow:hidden;padding: .5em;margin-bottom:10px;border: 1px #fff solid;border-radius: 10px;background: #66666691;}
.mem_list li.mem_bx .msct li * {height:35px;  float:left;}
.mem_list li.mem_bx .msct li .t{width:20%; display:inline-block; line-height:35px; font-weight:bold; }
.mem_list li.mem_bx .msct li .c{width:80px; margin:0 10px; line-height:35px; }
.mem_list li.mem_bx .msct li .ipt_num{width:calc(100% - 40px); padding-left:0.5em; text-align:center; background:#cdcdcd; border:0; border-radius:10px;}
.mem_list li.mem_bx .msct li .ipt_arw {width:20px; line-height:normal; margin-left:5px;}
.mem_list li.mem_bx .msct li .ipt_arw img{width:100%; height:auto;}
.mem_list li.mem_bx .msct li .ipt_arw div{width:15px; height:15px;}
.mem_list li.mem_bx .msct li .ipt_arw div:first-child{margin-bottom:3px;}
.mem_list li.mem_bx .msct li .ipt_arw button{width:100%; height:100%;background:transparent}
.mem_list li.mem_bx .msct li .ipt_reset{width:60px; /*  font-family:'HeirofLight'; color:#254928; padding:7px 0px; border-radius: 50px; overflow:hidden; background-color:#51a14d; background-repeat:no-repeat; background-size:100% 100%; background-position: 0 0;text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff; border:0; */}
.mem_list li.mem_bx .msct li .ipt_reset img{width:100%;height:auto; }
.mem_list li.mem_bx .msct .org {background-color:#f7eacf}
.mem_list li.mem_bx .msct .sky {background-color:#dcfafa;}
.mem_list .ipt_submit{background:transparent;position:absolute; right:15px; top:50%; margin-top:-26px; height:52px; width:80px; /*height:40px;  top:50%; margin-top:-25px; font-size:1.05em; font-family:'HeirofLight'; color:#254928; padding:7px 0px; border-radius: 50px; overflow:hidden; background-color:#2558f0; background-repeat:no-repeat; background-size:100% 100%; background-position: 0 0;text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff; border:0;*/}
.mem_list .ipt_submit img {width:100%;height:auto; }


</style>
