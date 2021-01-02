<?php
include_once('./_common.php');

$g5['title'] = '나의 그룹 ';
$docu_title=$g5['title'];

add_javascript('<script src="'.G5_THEME_URL.'/extend/jquery.ui.touch-punch.min.js"></script>');

$bg_type = "sub";
include_once('../_head.php');
$mb_id = $member['mb_id'];
$query = "select date_format(if(soled_date='0000-00-00',ct_validdate,soled_date),'%Y-%m-%d') dates, sum(ct_sell_price) sell,sum(ct_buy_price) buy,sum(ct_sell_price - ct_buy_price) amt,count(code) cnt  from {$g5['cn_item_cart']} where mb_id='$mb_id' and is_soled='1' group by date_format(if(soled_date='0000-00-00',ct_validdate,soled_date),'%Y-%m-%d') order by ct_validdate desc, soled_date desc";
$result=sql_query($query, 1);
$tot_amt=$tot_cnt=$tot_sell=$tot_buy=0;
$display = [];
while ($ds=sql_fetch_array($result)) {
	$display[] = [
		"dates"=>$ds['dates'],
		"sell"=>$ds['sell'],
		"buy"=>$ds['buy'],
		"amt"=>$ds['amt'],
		"cnt"=>$ds['cnt']
	];
	$tot_amt+=$ds['amt'];
	$tot_buy+=$ds['buy'];
	$tot_sell+=$ds['sell'];
	$tot_cnt+=$ds['cnt'];
}
?>
<link rel="stylesheet" href="<?php echo G5_THEME_URL ?>/skin/board/basic/style.css?ver=171222201210075048"  crossorigin="anonymous">
    
<div style="height:92vh;text-align:center;" id="Contents">
<div class="bo_list">
    <img src="<?php echo G5_THEME_URL ?>/images/head_income.png" style="width:100%" width=100% alt="">
        
        <div class="wrap">
            <div class="main_top_box">
                <p  style="position:relative">수익현황 <span style="position:absolute;right:0;color:#ffff00">원화</span></p>
            </div>
        </div>
			<div class="wrap">
				<div class="main_top_box">
					<div class="tbl_head01 tbl_wrap">
						<table class="m-0">
							<thead>
								<tr>
								<th id="mb_list_id" scope="col">날짜</a></th>
								<th id="mb_list_id" scope="col">구매금액</a></th>
								<th id="mb_list_id" scope="col">판매금액</a></th>
								<th id="mb_list_id" scope="col">이익</a></th>
								<th scope="col" >건수</a></th>

								</tr>
							</thead>
							<tbody>
                            <tr class="<?php echo $bg; ?>">
                                <td  >총</td>
                                <td  ><strong><?php echo number_format2($tot_buy) ?></strong></td>
                                <td  ><strong><?php echo number_format2($tot_sell) ?></strong></td>
                                <td  ><strong><?php echo number_format2($tot_amt) ?></strong></td>
                                <td  ><strong><?=number_format2($tot_cnt)?></strong></td>
                            </tr>
							<?php foreach ($display as $ds) {?>
								<tr class="<?php echo $bg; ?>">
									<td  ><?php echo $ds['dates'] ?></td>
									<td  ><?php echo number_format2($ds['buy']) ?></td>
									<td  ><?php echo number_format2($ds['sell']) ?></td>
									<td  ><?php echo number_format2($ds['amt']) ?></td>
									<td  ><?=number_format2($ds['cnt'])?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
</div>

    </div>
<style>


/* 기본테이블 */
.tbl_wrap table {margin:50px 0;width:100%;border-collapse:collapse;border-spacing:0 5px;border-top:1px solid #ececec;border-bottom:1px solid #ececec} 
.tbl_wrap caption {padding:10px 0;font-weight:bold;text-align:left}
.tbl_head01 {margin:0 0 10px}
.tbl_head01 caption {padding:0;font-size:0;line-height:0;overflow:hidden}
.tbl_head01 thead th {padding:5px;font-weight:normal;text-align:center;border-bottom:1px solid #ececec;height:40px;}
.tbl_head01 thead th input {vertical-align:top} /* middle 로 하면 게시판 읽기에서 목록 사용시 체크박스 라인 깨짐 */
.tbl_head01 tfoot th, .tbl_head01 tfoot td {padding:10px 0;border-top:1px solid #c1d1d5;border-bottom:1px solid #c1d1d5;text-align:center}
.tbl_head01 tbody th {padding:8px 0;border-bottom:1px solid #e8e8e8}
.tbl_head01 td {padding:5px;border-top:1px solid #ecf0f1;border-bottom:1px solid #ecf0f1;line-height:1.4em;word-break:break-all}
.tbl_head01 tbody tr:hover td {}
.tbl_head01 a:hover {text-decoration:underline}

.tbl_head02 {margin:0 0 10px}
.tbl_head02 caption {padding:0;font-size:0;line-height:0;overflow:hidden}
.tbl_head02 thead th {padding:5px 0;border-top:1px solid #d1dee2;border-bottom:1px solid #d1dee2;color:#383838;font-size:0.95em;text-align:center;letter-spacing:-0.1em}
.tbl_head02 thead a {color:#383838}
.tbl_head02 thead th input {vertical-align:top} /* middle 로 하면 게시판 읽기에서 목록 사용시 체크박스 라인 깨짐 */
.tbl_head02 tfoot th, .tbl_head02 tfoot td {padding:10px 0;border-top:1px solid #c1d1d5;border-bottom:1px solid #c1d1d5;text-align:center}
.tbl_head02 tbody th {padding:5px 0;border-top:1px solid #e9e9e9;border-bottom:1px solid #e9e9e9;}
.tbl_head02 td {padding:5px 3px;border-top:1px solid #e9e9e9;border-bottom:1px solid #e9e9e9;line-height:1.4em;word-break:break-all}
.tbl_head02 a {}
</style>
