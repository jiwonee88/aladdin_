<?php

include_once('./_common.php');

$outer_css=' stoneDetail';

$bg_type = "ramp";
include_once('../_head.php');

$isum=get_itemsum($member[mb_id]);
?>
  
        <div class="wrap">
            <!--div class="area area03">
                <ul class="common">
                    <li class="squareWB stone w100 clearfix">
                        <span class="stoneBg confirm">MY STONE</span>
                        <p class="f_right">
                            <p class="buyBtn">6일</p>
                            <p  class="buyBtn">18%</p>
                            <p  class="buyBtn">80</p>
                        </p>

                    </li>
                </ul>
				
                <div class="stoneTxt">보유중인 상품이 없습니다.</div>
				
				
            </div-->
			<?
			$temp=sql_fetch("select count(*) cnt from {$g5['cn_item_cart']} where mb_id='$member[mb_id]'  and is_soled!='1'  ",1);
			?>
			
			<ul class="stoneList">				
					<?
					$re=sql_query("select * from {$g5['cn_item_cart']} where mb_id='$member[mb_id]' and is_soled!='1'  group by cn_item order by cn_item ",1);					
					while($data=sql_fetch_array($re)){
					
					$re2=sql_query("select * from {$g5['cn_item_cart']} where mb_id='$member[mb_id]' and cn_item='$data[cn_item]'  and is_soled!='1' ",1);
					?>
                    <li class="squareWB">
                        <div class="clearfix">
                            <div class="stoneImg f_left">
                                <img src="<?=G5_THEME_URL?>/images/item/<?=$g5[cn_item][$data[cn_item]]['img']?>" alt="<?=$g5[cn_item][$data[cn_item]]['name_kr']?>">
                            </div>
                            <div class="stoneDesc f_left">
                                <h4 class='my-1' ><?=$g5[cn_item][$data[cn_item]]['name_kr']?></h4>
                                <ul style="padding-top:10px">
                                    <li class="goldInfo">
									<span class="howlong">보유<?=$g5[cn_item][$data[cn_item]]['days']?><? //=ceil((time()-strtotime($data[ct_wdate]))/86400)?>일</span><span class="percent"><?=$data[ct_interest]?>%</span>
                                    </li>                                    
                                    <li class="holdVol"><span>보유수량:<?=sql_num_rows($re2)?></span></li>
                                </ul>
                            </div>
						</div>	
						<div class="clearfix p-0">	
							<ul class='mt-0 w-100'>
								<li class='mr-4' >
								<?								
								while($data2=sql_fetch_array($re2)){
									$past_day=ceil( (strtotime(date("Y-m-d")) - strtotime($data2['ct_validdate'])) /86400 );
								?>
								<dl class='item_grid'>
									<dd>보유마감 <?=$past_day?>일</dd>
									<dd>
										<a href='' 
										class='ml-2 trans-btn' 
										data-code='<?=$data2[code]?>' 
										data-price='<?=$data2[ct_sell_price]?>' 
										data-name='<?=$g5[cn_item][$data[cn_item]]['name_kr']?>'>
											<img src="<?=G5_THEME_URL?>/new_img/btn_gold.png" style="width:130px">
										</a>
									</dd>
								</dl>


							<? }?>
								</li>
								
							</ul>


                        </div>
						
						
                    </li>
					<? }?>

					
					
                </ul>
				
				

        </div>
<div class="popup i02">
	<form name='transform' id='transform' onsubmit='transform_submit(this);' action='./item_trans_point.php' >
		<input type='hidden' name='w' value='t' >	
		<input type='hidden' name='code' value='' >		
		<input type='hidden' name='amt' id="form_amt" value='' >		
		<input type='hidden' name='point' id="form_point" value='' >			

		<h4>포인트 변환 신청</h4>			
		<ul>
			<li class='text-left'>
			 <p>변환할 나비 : <is id='item_name'></is></p>
			 
			</li>					
			<li class='text-left'>
			 <p>나비 금액 : <is id='item_price'></is></p>
			 
			</li>
			<li style="margin-top:20px;">
				<p  class='w-100 text-left'>꽃<?=$g5[cn_cointype]['i']?> : <is id='amt_i'><?=number_format($rpoint['e']['_enable'])?></is> 지급 </p>
			</li>        
			<li style="margin-top:20px;">
				<p  class='w-100 text-left'><?=$g5[cn_cointype]['s']?> : <is id='amt_s'>0</is> 지급</p>
			</li>                   
		</ul>

		<div class="btns w-100">
			<ul class='w-100'>
				<li class='w-50'>
					<button type='submit' >확인</button>
				</li>
				<li class='w-50'>
					<button type='button' class='btn-close' >닫기</button>
				</li>
			</ul>
		</div>
	</form>
</div>

<div class="popup i03">
	<form name='new_transform' id='new_transform' onsubmit='new_transform_submit(this);' action='./item_trans_point.php' >
		<input type='hidden' name='w' value='t' >	
		<input type='hidden' name='new_code' value='' >		
		<input type='hidden' name='amt' id="new_form_amt" value='' >		
		<input type='hidden' name='point' id="new_form_point" value='' >		

		<h4>포인트 변환 신청</h4>			
		<ul>
			<li class='text-left'>
			 <p>변환할 나비 : <is id='new_item_name'></is></p>
			 
			</li>					
			<li class='text-left'>
			 <p>나비 금액 : <is id='new_item_price'></is></p>
			 
			</li>
			<li style="margin-top:20px;">
				<p  class='w-100 text-left'>꽃<?=$g5[cn_cointype]['i']?> : <is id='new_amt_i'><?=number_format($rpoint['e']['_enable'])?></is> 지급 </p>
			</li>                    
		</ul>

		<div class="btns w-100">
			<ul class='w-100'>
				<li class='w-50'>
					<button type='submit' >확인</button>
				</li>
				<li class='w-50'>
					<button type='button' class='btn-close' >닫기</button>
				</li>
			</ul>
		</div>
	</form>
</div>


<script>
$(document).ready(function () {
	
	$('.trans-btn').click(function () {
		event.preventDefault();
		$('.popup.i02').addClass('on');
		
		var item_price=parseFloat($(this).attr('data-price'));
		
		$("#item_name").html($(this).attr('data-name'));
		$("#item_price").html(item_price);
		
		$("input[name=code]","#transform").val($(this).attr('data-code'));
		
		$(".sendInfo.buyPopup").addClass("on");
		$(".mask").addClass("on");
		
		var amt_i=Math.floor((item_price/<?=$sise['sise_i']?>)*(<?=$config[cf_percent1]?>/100));
		var amt_s=Math.floor((item_price/<?=$sise['sise_s']?>)*(<?=$config[cf_percent2]?>/100));
		$("#amt_i").html(inputNumberFormat(amt_i));
		$("#amt_s").html(inputNumberFormat(amt_s));
		$("#form_amt").val(amt_i);
		$("#form_point").val(amt_s);
	});
	
	$('.trans-new-btn').click(function () {
		event.preventDefault();
		$('.popup.i03').addClass('on');
		
		var item_price=parseFloat($(this).attr('data-price'));
		
		$("#new_item_name").html($(this).attr('data-name'));
		$("#new_item_price").html(item_price);
		
		$("input[name=new_code]","#new_transform").val($(this).attr('data-code'));
		
		$(".sendInfo.buyPopup").addClass("on");
		$(".mask").addClass("on");
		
		var new_amt_i=Math.floor((item_price/<?=$sise['sise_i']?>)*(<?=$config[cf_percent3]?>/100));
		$("#new_amt_i").html(inputNumberFormat(new_amt_i));
		$("#new_form_amt").val(new_amt_i);
		$("#new_form_point").val(0);
	});
	
	$('.btns .btn-close').click(function () {
		$(this).closest('.popup').removeClass('on');
	});
	
});


function sum(){
	var price=$('input[name=cn_price]','#buyform').val();	
	var qty=$('select[name=qty] option:selected','#buyform').val();
	
	var sum=parseInt(price) * parseInt(qty);
	
	$('#sum_str').html(inputNumberFormat(sum));
}

//  상품 구매

function transform_submit(f)
{
	
		
	event.preventDefault();
	Swal.fire({
	  title: '',
	  text: "<?=lng('포인트 변환을 진행하시겠습니까? 즉시 변환되며 다시 되돌릴수 없습니다')?>",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: '<?=lng('진행합니다')?>'
	}).then((result) => {
	  if (result.value) {		
	
			var formData = $(f).serialize();		

			$.ajax({
				type: "POST",
				url: "./item_trans_point.php",
				data:formData,
				cache: false,
				async: false,
				dataType:"json",
				success: function(data) {

					if(data.result==true){			
						$('.popup.i02').removeClass('on');						
						
						Swal.fire({
						  title: '',
						  html: data.message						  
						}).then((result) => {
							document.location.href='./stonedetail.php';
						})
						

					}
					else Swal.fire({html:data.message});
				}
			});		
	
	
	  } //if (result.value) {
	})
	
	return;
	
	
}
//  상품 구매

function new_transform_submit(f)
{
	
		
	event.preventDefault();
	Swal.fire({
	  title: '',
	  text: "<?=lng('포인트 변환을 진행하시겠습니까? 즉시 변환되며 다시 되돌릴수 없습니다')?>",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: '<?=lng('진행합니다')?>'
	}).then((result) => {
	  if (result.value) {		
	
			var formData = $(f).serialize();		

			$.ajax({
				type: "POST",
				url: "./new_item_trans_point.php",
				data:formData,
				cache: false,
				async: false,
				dataType:"json",
				success: function(data) {

					if(data.result==true){			
						$('.popup.i03').removeClass('on');						
						
						Swal.fire({
						  title: '',
						  html: data.message						  
						}).then((result) => {
							document.location.href='./stonedetail.php';
						})
						

					}
					else Swal.fire({html:data.message});
				}
			});		
	
	
	  } //if (result.value) {
	})
	
	return;
	
	
}

    </script>
			
			
<?	
include_once('../_tail.php');
?>

<style>
.item_grid dd {display: inline-block;width:49.5%;text-align: center;}
</style>
