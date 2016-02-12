<body>
	<div class="banner">
		<svg width="100" height="80" xmlns="http://www.w3.org/2000/svg">
		 <!-- Created with SVG-edit - http://svg-edit.googlecode.com/ -->

		 <g>
		  <title>Logo</title>
		  <ellipse fill="#e5e5e5" stroke="#000000" stroke-width="5" stroke-dasharray="null" stroke-linejoin="null" stroke-linecap="null" cx="40" cy="40.65" id="svg_3" rx="30" ry="13"/>
		  <path fill="none" stroke="#000000" stroke-width="5" stroke-dasharray="null" stroke-linejoin="null" stroke-linecap="null" d="m1066.35388,472.04901l35.27698,0l7.57483,-20.80139l22.3241,8.12091l-4.61951,12.68048l13.66064,0l0,23.7583l-22.30334,0l-4.32336,11.87909l26.62671,0l0,23.75409l-35.27734,0l-7.57446,20.80713l-22.32458,-8.12695l4.62,-12.68018l-13.66064,0l0,-23.75409l22.30334,0l4.32336,-11.87909l-26.62671,0l0,-23.7583z" id="svg_2"/>
		  <ellipse fill="#3f7f00" stroke="#000000" stroke-width="5" stroke-dasharray="null" stroke-linejoin="null" stroke-linecap="null" cx="57.5" cy="53.15" id="svg_4" rx="33.5" ry="13.5"/>
		  <ellipse fill="#666666" stroke="#000000" stroke-width="5" stroke-dasharray="null" stroke-linejoin="null" stroke-linecap="null" cx="64" cy="39.65" id="svg_5" rx="28" ry="14"/>
		  <path fill="#5fbf00" stroke="#000000" stroke-width="5" stroke-dasharray="null" stroke-linejoin="null" stroke-linecap="null" d="m54.34906,34.92346l16.4173,0l3.52557,-9.6817l10.38739,3.77945l-2.14862,5.90225l6.3598,0l0,11.05435l-10.38165,0l-2.01379,5.52789l12.39545,0l0,11.05435l-16.4173,0l-3.52557,9.6817l-10.38739,-3.78088l2.14862,-5.90082l-6.3598,0l0,-11.05435l10.38452,0l2.01093,-5.52789l-12.39545,0l0,-11.05435l-0.00001,0z" id="svg_1"/>
		 </g>
		</svg>	
		<h1 class="logo">Armourtake</h1>
	</div>
	<nav class="nav">
		<?php if($data['page_name']){echo '<h3 class="page-name">' . $data['page_name'] . "</h3>\n";}?>
		<ul>
			<li class="navbar"><a href="/armourtake/public/home">Home</a></li>
			<?php 
			if($data['loggedIn'] == 1){
			?>	
			<li class="navbar" id="user-dropdown">
			<a href="/account/profile"><?=$data['name']?></a><br>
				<ul id="drop-down" class="drop-down">
					<li class="drop-down"><a href="/armourtake/public/login/logout">Logout</a></li>
					<li class="drop-down"><a href="/armourtake/public/account/update">Update details</a></li>
					<li class="drop-down"><a href="/armourtake/public/account/change_password">Change password</a></li>
				</ul>
			</li>
			<?php
			}else if($data['loggedIn'] == 0){
			?>		
			<li class="navbar">
				<a href="/armourtake/public/login/">Login</a>
			</li>
			<?php 
			}
			if(!isset($data['register'])){
			?>
			<li class="navbar">
				<a href="/armourtake/public/register/">Register</a>
			</li>
			<?php
			}
			?>	
		</ul>
	</nav>
