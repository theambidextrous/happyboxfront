<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$util->ShowErrors(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>HappyBox :: Terms &amp; Conditions of Purchase</title>

<!-- Bootstrap core CSS -->
<?php include 'shared/partials/css.php'; ?>
</head>
<body class="client_body">
<!-- Navigation -->
<?php include 'shared/partials/nav.php'; ?>
<!-- Page Content -->

<section class=" terms_banner">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="text-white">TERMS &amp; CONDITIONS</h3>
			</div>
		</div>
	</div>
</section>
<section class=" terms_sub_banner">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h4 class=""> HappyBox Terms and Conditions of Purchase <br>
				<i>As of 1st October 2020</i> </h4>
			</div>
		</div>
	</div>
</section>

<!--end discover our selection-->
<section class="container section_padding_top terms_content">
	<div class="row">
		<div class="col-md-12">
			<p>HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher. Whilst every effort is made to ensure the descriptions and pictures contained within the website and on the vouchers are a true reflection of the events in respect of which the voucher may be redeemed, these do not form part of a contract. If on contacting the Partner to redeem your voucher you feel that the activity taking place no longer accurately represents the activity shown on the HappyBox website or the vouchers, please contact the Customer Service and share this concern with our teams. Once a specific date has been booked, you will automatically become bound by the terms and conditions that individual Partners may have. Please note that experiences are subject to change without notice. This does not affect your statutory rights.</p>
			<div class="terms_li">
				<h5>1. Prices</h5>
				<p>The prices of specific experiences against which vouchers can be redeemed which are displayed on our website are correct to the best of our knowledge and maintained on a daily basis. In the event of a voucher being issued at or redeemed against an accidental incorrect price, we will endeavour to inform the purchaser of the error within seven (7) days of the voucher purchase / voucher redemption being made, we will allow the recipient to either obtain a full refund against the voucher or choose to pay the additional difference in price. Promotional discount codes can only be redeemed against certain HappyBox experiences.</p>
			</div>
			<div class="terms_li">
				<h5>2. Availability</h5>
				<p>HappyBox sells vouchers which are valid for six (6) months from the date of issue (unless otherwise stated) and each recipient is free to book their preferred date for their chosen experience. The experiences in respect of which vouchers may be redeemed are subject to availability and in some cases, subject to weather conditions on the day. In order to avoid disappointment, we recommend that you book the experience in respect of which the voucher will be redeemed well in advance and DO NOT organise travel or accommodation until the booking has been confirmed by the Partner.</p>
			</div>
			<div class="terms_li">
				<h5>3. Booking</h5>
				<p>Please do not arrive at a venue expecting to redeem your voucher without first making a booking with the Partner. HappyBox will not be held liable for any costs incurred if you do not follow the procedure set out in these Terms and Conditions and in your voucher pack.</p>
			</div>
			<div class="terms_li">
				<h5>4. Event Duration</h5>
				<p>Details of event duration given on the website or the voucher are to be used as a guide only. Most events will be 'open' days, meaning that other members of the public will be taking part too. This could mean taking your turn with other members of the public. The information on our website and voucher is meant as an indication of what to expect at the session in respect of which your voucher is redeemed. As HappyBox vouchers can be redeemed in return for multi-location experiences, session lengths, agendas, vehicles used, numbers of participants and other factors specific to that experience may vary from location to location. Delays, curtailments and breakdowns are not within our control and therefore we cannot be held liable.</p>
			</div>
			<div class="terms_li">
				<h5>5. Safety</h5>
				<p>The undertaking of these activities may involve some personal risk. With some events you may be required to sign a disclaimer on the day, please read these documents carefully. Some personal insurance policies may not cover some of the experiences in respect of which our vouchers may be redeemed. Please check with the Partner and your insurer well in advance of your day. Note that Partners usually require participants to comply with specified safety procedures. Please listen and take note if they ask you to do something - it is usually for your own safety.</p>
			</div>
			<div class="terms_li">
				<h5>6. Validity</h5>
				<p>Each voucher is valid for a maximum of six (6) months from the date of purchase unless otherwise stated. A voucher will be deemed to be invalid if it is out of date (the validity date is clearly stated on the HappyBox website once the user has activated his voucher). Vouchers can only be extended if they are still inside their expiry date, if they have not been previously used, and if the experience is still available from the supplier. If the activity in respect of which the voucher is to be redeemed has increased in price, the customer will also need to pay the difference in price. All experiences should be booked and taken before the expiry date available on the HappyBox website.</p>
			</div>
			<div class="terms_li">
				<h5> 7. Choosing the right experience</h5>
				<p>Many of the vouchers offered may be redeemed for experiences which have some type of restriction applied to them; these restrictions are not decided by us but by the individual Partner. These restrictions could include age, health, physical and size restrictions. Please read all the information provided for each experience, to ensure that your initial suggested voucher is the right one for the recipient. If you are unsure of the suitability of a particular event, please contact the HappyBox Customer Service Team, <a href="mailto:customerservices@happybox.ke">customerservices@happybox.ke</a>, with your query and we will advise you accordingly. Alternatively, you can contact our customer service by phone: <a href="tel:+254112454540">+254 112 454 540</a>.</p>
			</div>
			<div class="terms_li">
				<h5>8. Complaints</h5>
				<p>The easiest way to resolve any problems that you may experience is to speak to the Partner on the day. They will ensure that any issues are rectified. If you are still not satisfied, please send in details of your complaint (including your voucher reference number and the name of the person you spoke to on the day) to: HappyBox Customer Service Team, <a href="mailto:customerservices@happybox.ke">customerservices@happybox.ke</a>, alternatively, you can contact our customer service by phone: <a href="tel:+254112454540">+254 112 454 540</a>. Please remember that the Partner will have the opportunity to respond as well. Similarly, we would like to hear any positive feedback. Email us on <a href="mailto:customerservices@happybox.ke">customerservices@happybox.ke</a>.</p>
			</div>
			<div class="terms_li">
				<h5>Mediation and conciliation</h5>
				<p>Where the complaint is not addressed satisfactorily by the Partner, you agree to mediation and conciliation prior to pursuing other dispute resolution mechanisms under this agreement.</p>
			</div>
			<div class="terms_li">
				<h5>Arbitration</h5>
				<p>Should parties not resolve their dispute amicably as provided in this clause 8, within fourteen (14) days such a dispute, difference or question touching upon the construction of this Agreement shall be referred to the decision of a single arbitrator to be agreed between the parties within fourteen (14) days. In the event that parties are unable to agree on an arbitrator one shall be appointed at the request of either of the parties by the chairman for the time being of the institute of Chartered Arbitrators – Kenya Branch in accordance with and subject to the provisions of the Arbitration Act (Cap 49 Laws of Kenya) or any statutory modification or re-enactment thereof for the time being in force:
				<ol style="list-style-type: none;">
					<li>a) To the extent permissible by Law, the determination of the Arbitrator shall be final, conclusive and binding upon the Parties hereto</li>
					<li>b)	Pending final settlement or determination of a dispute, the Parties shall continue to perform their subsisting obligations hereunder.</li>
					<li>c)	Nothing in this Agreement shall prevent or delay a Party seeking urgent injunctive or interlocutory relief in a court having jurisdiction</li>
				</ol>
				</p>
			</div>
			<div class="terms_li">
				<h5>9. Cancellations</h5>
				<p>Once you book a specific date with a Partner you are bound by their terms and conditions regarding cancellations. Once a date is confirmed with a Partner it is not possible to change this date unless the Partner agrees to the change. In the event of a Partner accepting a cancellation, not a simple change in date, HappyBox will, where applicable, provide you with a newly generated voucher code in the limit of one (1) exchange. Where a date cannot be altered by a Partner it will not be possible to issue a refund. In the unlikely event that one of our Partners needs to cancel the experience after you have booked a date, they will contact you. We strongly recommend however, that you contact the Partner on the day before you depart for your experience. In the event of cancellation, HappyBox will not be held liable for the cost of lost insurance premiums, travel expenses, pre-booked accommodation costs or any other costs incurred.</p>
			</div>
			<div class="terms_li">
				<h5>10. Partners &amp; liability</h5>
				<p>When redeeming your voucher and booking an experience with a Partner you will be entering into a separate agreement with the Partner and will be bound by their own terms and conditions, including any restrictions applied by that Partner. Although HappyBox has sought to select highly experienced Partners of 'once in a lifetime' experiences, HappyBox cannot be responsible for the safety standards or the quality or delivery of the experience, or any loss or damage suffered by you whilst participating in the experience for which the Partner shall be solely responsible. By purchasing a HappyBox voucher and, booking an experience with a supplier, you acknowledge that the experience in respect of which the voucher will be redeemed is dependent on certain factors beyond the control of HappyBox and you agree that neither HappyBox nor any Partner shall be liable for the cancellation, postponement or alteration of any experience for reasons beyond its reasonable control, including weather-related reasons, mechanical failure, location changes or otherwise. We do not undertake any technical examination of equipment, facilities or services in order to minimise personal risk. If mechanical machinery breaks down, you should ask the Partner for reasonable substitutions without notice. The total liability of HappyBox for any claim whatsoever in connection with the HappyBox voucher or any experience in respect of which a voucher is redeemed shall be limited to the price paid for the experience voucher. We have tried to ensure that the descriptions and images used on all marketing material are accurate. However, images are intended to give a general idea of the experience described and do not form part of any contract between the purchaser and / or the recipient of the voucher and HappyBox.</p>
			</div>
			<div class="terms_li">
				<h5>11. Spectators</h5>
				<p>Most Partners will allow you to bring spectators to watch you participate in your selected experience. When redeeming your voucher and booking your date please inform the Partner that you wish to bring other people. Some Partners may request a nominal payment for spectators. Spectators are required to comply with the Partners' terms, conditions and expectations of conduct. Any spectators deemed under the influence of drugs or alcohol will not be permitted on site.</p>
			</div>
			<div class="terms_li">
				<h5>12. Vouchers</h5>
				<p>The voucher is invalid if it has been tampered with or defaced. HappyBox accepts no responsibility for lost or stolen vouchers. Please keep the vouchers in a safe place and protect them as you would money. We urge you to activate your voucher on <a href="https://happybox.ke">https://happybox.ke</a> as soon as possible in order to benefit from our loss and theft warranty.</p>
			</div>
			<div class="terms_li">
				<h5>13. Discount Codes</h5>
				<p>Discount codes are issued subject to availability and can be withdrawn without notice at any time. Only one discount may be used per order and these cannot be used against exchanges, extensions, delivery, gift packs or any other facility provided by HappyBox. Discounts can only be applied to internet orders on <a href="https://happybox.ke">https://happybox.ke</a>. Discount codes cannot be used when exchanging experience vouchers or when redeeming credit vouchers and money vouchers. HappyBox reserves the right to stop discount codes being used against specific products.</p>
			</div>
			<div class="terms_li">
				<h5>14. Social Network Guidelines</h5>
				<p>User Conduct: You agree not to upload, post, email or otherwise transmit: (a) any User Content or other data that is false, inaccurate, unlawful, harmful, threatening, abusive, defamatory, vulgar, obscene, invasive of another's privacy, hateful, or that otherwise degrades or intimidates an individual or group of individuals on the basis of religion, gender, sexual orientation, race, ethnicity, age or disability; (b) any unsolicited or unauthorised advertising, promotional materials, "junk mail," "spam," or any other form of solicitation; or (c) any material that contains software viruses or any other computer code, files or programs designed to interrupt, damage, destroy or limit the functionality of any computer software or hardware or telecommunications equipment.</p>
				<p>Content posted by you: You acknowledge that you are responsible for all the information, data, text, software, photographs, graphics, video, messages and other materials ("User Content"), whether publicly posted or privately transmitted, which you upload, post, email or otherwise transmit via the website and/or social network services. With respect to all User Content you elect to post, you grant us the royalty-free, perpetual, irrevocable, non-exclusive and fully sub-licensable right and license to use, reproduce, modify, adapt, publish, translate, create derivative works from, distribute, perform and display such User Content (in whole or part) worldwide and/or to incorporate it in other works in any form, media, or technology now known or later developed. We shall have the right (but not the obligation) in our sole discretion to refuse, move or remove any User Content that violates these terms and conditions or is otherwise objectionable.</p>
			</div>
		</div>
	</div>
</section>
<!--end add to cart cards--> 
<!--our partners -->

<?php include 'shared/partials/partners.php';?>
<?php include 'shared/partials/footer.php';?>

<!-- Bootstrap core JavaScript -->

<?php include 'shared/partials/js.php';?>
</body>
</html>
