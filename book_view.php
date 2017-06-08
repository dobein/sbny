<?
	include "./include/inc_base.php";
	include "./include/inc_top.php";
?>
<script>
function top_round(w,c) {
var top_html;
top_html="<table align=center cellpadding=0 cellspacing=0 border=0 width="+w+">";
top_html+="<tr height=1><td rowspan=4 width=1></td><td rowspan=3 width=1></td>";
top_html+="<td rowspan=2 width=1></td><td width=2></td><td bgcolor="+c+"></td>";
top_html+="<td width=2></td><td rowspan=2 width=1></td><td rowspan=3 width=1></td>";
top_html+="<td rowspan=4 width=1></td></tr><tr height=1><td bgcolor="+c+"></td>";
top_html+="<td bgcolor="+c+"></td><td bgcolor="+c+"></td></tr>";
top_html+="<tr height=1><td bgcolor="+c+"></td><td colspan=3 bgcolor="+c+"></td>";
top_html+="<td bgcolor="+c+"></td></tr><tr height=2><td bgcolor="+c+"></td>";
top_html+="<td colspan=5 bgcolor="+c+"></td><td bgcolor="+c+"></td></tr></table>";
document.write(top_html);
}

function bottom_round(w,c) {
var bottom_html;
bottom_html="<table align=center cellpadding=0 cellspacing=0 border=0 width="+w+">";
bottom_html+="<tr height=2><td rowspan=4 width=1></td><td width=1 bgcolor="+c+"></td><td width=1 bgcolor="+c+"></td>";
bottom_html+="<td width=2 bgcolor="+c+"></td><td bgcolor="+c+"></td><td width=2 bgcolor="+c+"></td>";
bottom_html+="<td width=1 bgcolor="+c+"></td><td width=1 bgcolor="+c+"></td><td rowspan=4 width=1></td></tr>";
bottom_html+="<tr height=1><td rowspan=3></td><td bgcolor="+c+"></td><td colspan=3 bgcolor="+c+"></td>";
bottom_html+="<td bgcolor="+c+"></td><td rowspan=3></td>  </tr><tr height=1><td rowspan=2></td>";
bottom_html+="<td bgcolor="+c+"></td><td bgcolor="+c+"></td><td bgcolor="+c+"></td><td rowspan=2></td></tr>";
bottom_html+="<tr height=1><td></td><td bgcolor="+c+"></td><td></td></tr></table>";
document.write(bottom_html);
}

</script>
<script>
	function lets_go(){

			category1 = document.search_category.main_category.value;
			state1 = document.search_category.state.value;

			location.replace('kin_list.php?category=' + category1 + '&state=' + state1);
		
	}
</script>
	<table width="94%" align=center border=0 cellpadding=0 cellspacing=0 >
		<tr bgcolor=#f4f4f4>
			<td height=35 align=left class="title_font">&nbsp;&nbsp;Germanium</td>
		</tr>
	</table>
	<br>

	<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width=25% valign=top >
				<? include "left_menu.php"; ?>
			</td>
			<td width=75% valign=top bgcolor=#FFFFFF>
<!-- 메인 메뉴 -->
<table width="98%" align=center border="0" cellspacing="0" cellpadding="0" style='border-top: dotted #CCCCCC 1px; border-bottom: dotted #CCCCCC 1px;'>
  <tr bgcolor='#fff5ee'> 
	<td height=23 colspan=3>&nbsp;&nbsp;<b>Related books to Germanium</b></a></td>
  </tr>
</table>
<br>
<table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
<script>top_round('580','#F9F9F9');</script>
<table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#F9F9F9">
<tr> 
<td align=center><img src='./img/book1.gif'>
</td>
<td> 
<b><a name="first"></a><font size="4"><br>
GERMANIUM</font></b><br>
<br>
<b><font size="4">A NEW APPROACH TO IMMUNITY</font></b><br>
<br>
by Betty Kamen, Ph.D.

</td>
</tr>
<tr> 
<td colspan="2"><a href="#intro">Introduction</a><br>
<br>
<font color="#C11D00">Chapter 1</font><br>
<a href="#1-1">The discovery of organic germanium</a><br>
<a href="#1-2">Germanium discovery</a><br>
<a href="#1-3">Early experiments</a><br>
<br>
<font color="#C11D00">Chapter 2</font><br>
<a href="#2-1">The need for organic germanium</a><br>
<a href="#2-2">The beginning of disease</a><br>
<a href="#2-3">Free radicals</a><br>
<a href="#2-4">Antioxidants</a><br>
<a href="#2-5">The anaerobic cell</a><br>
<a href="#2-6">Vitamin O: The oxygen nutrient</a><br>
<a href="#2-7">Oxygen and the athlete</a><br>
<a href="#2-8">Oxygen and longevity</a><br>
<a href="#2-9">More Consequences of Oxygen deficiency</a><br>
<br>
<font color="#C11D00">Chapter 3</font><br>
<a href="#3-1">Validation of organic germanium: Uses in medicine</a><br>
<a href="#3-2">Studies confirming benefits of organic germanium</a><br>
<a href="#3-3">A few more reports</a><br>
<br>
<font color="#C11D00">Chapter 4</font><br>
<a href="#4-1">How organic germanium may work to maintain or restore health?</a><br>
<a href="#4-2">Organic germanium as an adaptogen</a><br>
<a href="#4-3">Orgenic germanium as an Oxygen enhancer</a><br>
<a href="#4-4">Organic germanium as detoxifier</a><br>
<a href="#4-5">Organic germanium and the body electric</a><br>
<a href="#4-6">Organic germanium and hypoxia</a><br>
<a href="#4-7">Organic germanium and immunity</a><br>
<a href="#4-8">ORganic germanium and the American tradition<br>
</a><br>
<font color="#C11D00">Chapter 5</font><br>
<a href="#5-1">External applications of germanium to relieve stress and pain</a><br>
<a href="#5-2">External Applications of Germanium<br>
</a><br>
<font color="#C11D00">Chapter 6</font><br>
<a href="#6-1">Risks and Limits: Toxicity and Safety</a><br>
<br>
<font color="#C11D00">Chapter 7</font><br>
<a href="#7-1">A working plan for adding germanium to your diet</a><br>
<a href="#7-2">Table Talk</a><br>
<a href="#7-3">Germanium as a supplement</a><br>
<a href="#7-4">In Conclusion</a><br>
<br>
<font color="#C11D00"><a href="#appendix">Appendix A</a></font></td>
</tr>
<tr> 
<td colspan="2">
<table width="95%" border="0" cellspacing="0" cellpadding="5" align="center" bgcolor="#FFFFFF">
<tr bgcolor="#CCCCCC"> 
<td>MEDICAL UPDATE, 1993<br>
Process GE-I32 Improves Immunity Following Surgery</td>
</tr>
<tr>
<td>The effect of 2-carboxyethylgermanium sesquioxide pinball (GE-I32) as an interferon 
inducer on post-surgical immunosuppression was evaluated from the immuno- logical 
response augmented in canine neutrophils, mac- rophages, and peripheral blood 
lymphocytes, with a control group. Those in the Ge-132-administered group (Ge-132 
group) were enhanced for a long time surgery. These results suggest that Ge-132 
pre-treat- ment may be efficacious and useful in preventing the multifaceted clinical 
symptoms induced by post-op- erative immunosuppression in these test animals.<br>
<br>
Source: Journal of Veterinary Medical Science, 1993 Oct, 55(5):795-9.</td>
</tr>
<tr bgcolor="#CCCCCC"> 
<td>MEDICAL UPDATE, 1991<br>
GE-32 Shown to be Safe</td>
</tr>
<tr>
<td>During 28 days and six months, test animals received 1mg/kg/day of GE-132. 
No particular toxic symptoms, no behavior trouble, except a small decrease of 
body weight in male animals, at the end of the six-month experiment, were observed. 
Germanium urinary excretion was constant and linked to the received dose. Six 
months later, no preferential accumulation in organs was observed.<br>
<br>
Source: Journal de Toxicologie Clinique et Experimentale, 1991 Dec, 11(7-8):421-36. 
</td>
</tr>
<tr bgcolor="#CCCCCC"> 
<td>MEDICAL UPDATE, 1995<br>
GE-132 May Be Antimutagenic</td>
</tr>
<tr>
<td>Research studies suggest that various nutritional factors such as the antioxidant 
vitamins and selenium are very promising as potential anticarcinogenic agents. 
Moreover, some evidence exists showing germanium,. at specific dosage levels, 
may possess antimutagenic potential.<br>
<br>
Source: Department of Oral Biology, Indiana University School of Dentistry, Indianapolis 
46202. Mutation Research 1995 Aug, 335(1):21-6.</td>
</tr>
<tr bgcolor="#CCCCCC"> 
<td>MEDICAL UPDATE, 1995<br>
GE-132 Delays Cataract Progression</td>
</tr>
<tr>
<td>Ge-132 has been shown to be effective in preventing a process called "glycation," 
which results in lens opacification, or the development of cataracts. By preventing 
glycation, cataract progression can be delayed.<br>
<br>
Source: Department of Biological Sciences, Oakland University, Rochester, MI, 
Experimental Eye Research, August 1995.</td>
</tr>
<tr bgcolor="#CCCCCC"> 
<td>MEDICAL UPDATE, 1994<br>
Germanium Effective Against Tumors</td>
</tr>
<tr>
<td>The earliest reports on the therapeutic use of metals or metal-containing 
compounds in cancer and leukemia date from the sixteenth and nineteenth centuries. 
They were forgotten until the 1960s, when the antitumor activity of inorganic 
complexes were discovered. Numerous metal compounds, including germanium, have 
now been shown to be effective against tumors in man and experimental. tumors 
in animals. <br>
<br>
Source: European Journal of Clinical ,Pharmacology, 1994, 47(1):1-16.</td>
</tr>
<tr bgcolor="#CCCCCC"> 
<td>MEDICAL UPDATE, 1996<br>
Ge-132 Provides Relief for Chronic Fatigue</td>
</tr>
<tr>
<td>GE-132 has been found to provide relief from the debilitating symptoms of 
the Chronic Epstein-Barr Virus Syndrome, an affliction that may be affecting millions 
of Americans.<br>
<br>
Source: "Use of Organic Germanium in Chronic Epstein-Barr Virus Syndrome," Journal 
of Orthomolecular Medicine, 1989. </td>
</tr>
<tr bgcolor="#CCCCCC"> 
<td>MEDICAL UPDATE, 1992<br>
GE-132 Protects Cells from Injury</td>
</tr>
<tr>
<td>The effect of carboxyethylgermanium sesquioxide (GE-132) on injured cells 
of test animals was studied. When the cells were pretreated before injury, the 
cells were protected. All the effects of Ge-132 were dose-related. The results 
indicate that Ge-132 may improve the metabolism of certain cells and protect them 
from induced injury. <br>
<br>
Source: Yao Hsueh Hsueh Pao Acta Pharmaceutica Sinica, 1992, 27(7):481-5.</td>
</tr>
</table>
<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><br>
<br>
<br>
<br>
<a name="intro"></a>Although germanium had its beginnings in this country (it 
was used here successfully in 1922 to treat anemia), it "grew up" in Japan, where 
it is now consumed extensively as an adaptogen - a substance that does not cure, 
but helps the body to help itself.<br>
No one can predict how effective organic germanium might be for you or for anyone 
else. We do know that it's safe. The evidence validating its benefits has been 
increasing daily. The amounts chosen for use are arbitrary -just like those established 
for most vitamins and minerals but they appear to work clinically.<br>
Germanium's remarkable effects on the immune system have been documented in medical 
journals. It has also been selected as one of six substances to be studied in 
the treatment of AIDS, chosen at the International AIDS Treatment Conference held 
in Tokyo, Japan in February, 1987. Humanity waits anxiously for the results of 
this research.<br>
In true adaptogenic style, organic germanium appears to work to alleviate minor 
or major health imbalances, or to keep you free of problems. So it appears to 
be both therapeutic and preventive.<br>
Germanium is as old as the earth's crust, but its application is in tune with 
our new and increasing understanding of energy medicine.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a> <br>
<br>
</font> 
<hr noshade>
<font face="Verdana, Arial, Helvetica, sans-serif" size="2"> <br>
<br>
<br>
<br>
<b><a name="1-1"></a>Chapter 1</b><br>
<br>
<font color="#C11D00">THE DISCOVERY OF ORGANIC GERMANIUM</font><br>
<br>
When I learn about a substance used successfully in other countries to cure disease 
or to maintain health, my curiosity is aroused. When I discover that this substance 
has been almost totally ignored here, I am driven to action. That's what started 
my research on organic germanium, a mineral which has been found to enhance the 
immune system.<br>
Cures from nature are historic and varied. Those who think that the beneficial 
effects of garlic are no more than grandma's myth, may find the healing properties 
of aloe more convincing. Those who are not aware of aloe may grow comfrey or take 
it in supplemental form - because it, too, is a health-promoter. And those who 
may not relate any of these to disease prevention may consume chlorella - the 
ancient one-celled algae on record for helping to maintain health. Ginseng and 
watercress are also known for therapeutic properties. Needless to say, hundreds 
of plant foods can be added to this list. I have chosen to highlight garlic, aloe, 
comfrey, chlorella, ginseng, and watercress for a particular reason - they all 
contain germanium.<br>
Why haven't you heard of germanium (not to be confused with the flower, geranium) 
before? The answer is that it takes many years from the time a discovery is recognized 
to the time the significance of that revelation is applied. In fact, medical historians 
inform us that the average delay from journal reporting to actual clinical use 
is seventy or more years. TV satellites and widespread media exposure have not 
had a significant effect on expediting this process.<br>
The wisdom of the ages has helped people to know what is good for them long before 
science figures out why. In the sixteenth century, Francis Bacon wrote, "Cures 
are discovered before they <br>
are understood," and an old Chinese master explained that "healing is the intuitive 
art of wooing nature." Einstein told us, "The perception of mystery is the source 
of every learning and discovery." The more we examine organic germanium, the more 
pertinent all these prophetic statements appear to be.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a> <br>
<br>
<font color="#C11D00"><a name="1-2"></a>Germanium Discovery</font><br>
<br>
About a hundred years ago, a German chemist noticed the appearance of an unidentified 
chemical - a mineral occurring in small quantities in foods, coal deposits, and 
the earth's crust. He called the substance germanium. If you are old enough to 
have assembled a crystal radio in your youth, you may remember the germanium diode 
crystal, the active ingredient that was responsible for bringing in the radio 
signal that you heard in your earphone. The germanium atom is so structured that 
it accepts and transmits electrons, giving it a semiconductor capability. This 
means it becomes an electro-stimulator, inducing the flow of electricity. In its 
pure metallic form, germanium is used extensively in the electronics industry 
for transistors, fiber-optics, and other diverse applications. Biologically, it 
appears to be highly effective in stimulating electrical impulses on a cellular 
level and in its apparent role as an "oxygen catalyst," explained more fully later. 
In 1950, Dr. Kazuhiko Asai, a brilliant Japanese chemist, discovered traces of 
germanium in fossilized plants. The next news about germanium came from Russia, 
where reports suggested that germanium had anticancer activity. A few years later, 
Dr. Asai associated healing plants, medicinal herbs, and special waters with this 
common germanium bond: plants and waters known to have special therapeutic properties 
have relatively high concentrations of germanium. These plants, mentioned earlier, 
are garlic, aloe, comfrey, chlorella, ginseng, and watercress. Some additional 
plants also have significant quantities of germanium, but they are herbals that 
are not familiar to most people. For the herbologists, they are: <br>
shelf fungus (a variety of Reishi mushroom), shiitake mushrooms, pearl barley, 
sanzukon, sushi, watermt, boxthornseed, andwisteria knob.<br>
The holy water of Lourdes, known for its therapeutic value, also contains germanium. 
Other edible products contain germanium, but the ones I have listed have enough 
germanium to be worthy of notice, ranging in amounts from 100 to 2,000 parts per 
million.<br>
By 1967, Dr. Asai managed to synthesize a new compound of germanium and found 
that the manufactured substance itself (bisbeta-carboxyethyl germanium sesquioxide) 
has amazing curative powers. The product has come to be known as organic germanium. 
(You may wonder how something that is produced synthetically can bear the title 
"organic." Anything that contains carbon in its molecular architecture is organic, 
so synthetical ly.derived germanium is organic, according to definition.)<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="1-3"></a>Early Experiments<br>
</font><br>
One researcher in Japan used germanium in an experiment to grow ginseng. The results 
were quite fascinating. The plants receiving the germanium treatment exhibited 
improved growth as compared with those that were not getting such special exposure.<br>
In another experiment, this time with rice, it was discovered that germanium-treated 
plants had an increased resistance to cold. At a particular point in growth, greenhouse 
temperature was lowered; plants not treated with germanium withered and died, 
but the germanium-treated rice plants continued to thrive.<br>
Soon experiments were done with animals. In one study, animals submerged in water 
survived longer when they had been fed organic germanium. Organic germanium compounds 
were tested on cats, dogs, and horses, and found to have remarkable curative effects.<br>
When germanium is used as a stabilizing agent for tofu, the life of the tofu is 
extended - it simply doesn't spoil as rapidly.<br>
Some of you may remember when coca cola was bottled in plastic. The use of plastic 
bottles for coke was banned because of leaching problems. It was discovered, however, 
that the addition of germanium prevented the contamination. One Japanese researcher 
uses the cola story as analogous to our "polyester" lifestyle. "Taking germanium," 
he says, "eliminates or mitigates the deleterious effects of the plastic we wear, 
sit on, look at, and generally are enclosed in."<br>
In the last 20 years, germanium has become a household word in Japan. Frequently 
purchased in drug stores, it is to this day the subject of many trials and new 
studies. The early work on organic germanium proved to be the harbinger of a new 
nutrient star.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<hr noshade>
<br>
<br>
<br>
<br>
<b><a name="2-1"></a>Chapter 2</b><br>
<br>
<font color="#C11D00">THE NEED FOR ORGANIC GERMANIUM</font><br>
<br>
Germanium appears to play a role as an oxygen catalyst, an antioxidant, an electro-stimulant, 
and an immune enhancer. Before explaining how its use is correlated with these 
functions, and what these functions mean, background information on certain aspects 
of lifestyle and degenerative disease is important.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="2-2"></a>The Beginning of Disease</font><br>
<br>
I have a fantasy. I wish that every time anyone consumed highly processed foods, 
body cells would emit flashing red lights, bazooka noises, and fireworks, after 
which we would go TILT- just like a pinball machine which has been excessively 
manipulated. Can you imagine the colorful and noisy scenes in every restaurant 
serving high-fat, highsalt, high-sugar, over-processed meals? In my dream this 
would call attention to the root beginnings of the disease state. Your body would 
scream "no," or give you warning signals you couldn't ignore.<br>
Unfortunately, disease starts very quietly, without fanfare, on a cellular level. 
There are no flags or whistles when one cell becomes impaired, even though it 
is unable to function properly. There is no pain, distress, or discomfort when 
a cell dies and you are one cell older. As the process continues, you become several 
cells older, then many cells older. Whenenoughcells malfunction, tissue is affected. 
When enough tissue has been compromised, disease is noticed. Too little, too late, 
as the saying goes. What is the metabolic pathway that has caused that cell to 
die?<br>
A classic definition of cellular injury, as defined in Pathologic Basis of Disease, 
is "any adverse influence which deranges the cell's ability to maintain a steady, 
normal, or adaptive homeostasis."' Homeostasis is the ability to compensate for 
any changes caused by physical, emotional, or environmental stress in order to 
maintain optimal health.<br>
The physicians describing cellular injury conclude that "Lack<br>
of cellular oxygen supply is probably the most common cause of cell injury and 
may also be the ultimate mechanism of damage. "2<br>
Other researchers share the view that lack of oxygen to your cells, regardless 
of cause, leads to disease unless appropriately checked. Among the proponents 
of this view are giants in the scientific community: Hans Selye, Albert Szent-Gyorgyi, 
Otto Warburg, and more recently, Stephen A. Levine and Parris M. Kidd. It may 
be that organic germanium can bring much needed oxygen to your cells.<br>
Because oxygen is so reactive, it takes a healthy organism to maintain adequate 
oxygen levels. Examples of causes of diminished oxygen supply are atherosclerotic 
plaques or thrombi, which restrict the flow of blood. Heart attacks and strokes 
represent cell death caused by lack of oxygen as a resin t of the obstruction 
of blood to the heart or brain.<br>
Other situations which are responsible for lack of oxygen are extremes in temperature, 
sudden changes in atmospheric pressure (as experienced by deep sea divers), and 
poisoning of enzymes by toxins and environmental pollutants (especially lead, 
cadmium, and mercury). At no time in the history of humankind have we been exposed 
to more toxins and pollutants in the air we breathe, the water we drink, and the 
food we eat. Lifestyle in the late twentieth century has imposed a burden on our 
bodies by reducing the oxygen supply to our cells. This has occurred mainly through 
free radical reactions, the ultimate damage that starts with adverse exposures 
in an unnatural world.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="2-3"></a>Free Radicals</font><br>
<br>
Free radicals are highly reactive molecules. Although they are important for normal 
biological processes, they become destructive when they are out of control. In 
fact, free radicals are considered to be the mainspring of endless disease processes, 
and the major cause of aging. They can be detrimental by bonding with life-giving 
protein tissue, so that the tissue no longer performs its rejuvenating tasks. 
Free radicals attack cell membranes, accumulate in fat cells, and damage nucleic 
acids (RNA and DNA).<br>
Where do free radicals come from? Let me count the ways:<br>
All forms of radiation produce free radicals. This includes radiation from computers, 
radios, TV screens, microwaves, x-rays, radioactive fallout, and food irradiation.<br>
Any stress -whether it is caused by infections, emotions, or physical trauma - 
results in an increase of free radicals, which ultimately waste oxygen.<br>
Ground meats such as hamburgers, hot dogs, and sausages are at risk of peroxidation 
(the breakdown of fat in their membranes), thereby causing free radicals. The 
same is true of foods that contain a high oil content (nut butters, salad oils 
and dressings, whipped topping mixtures, foods fried in oil - potato chips, french 
fries, doughnuts).<br>
Sunlight, smog, ozone and other environmental pollutants (photochemicals, cigarette 
smoke, herbicides) are additional causes of free radical formation. Even normal 
metabolism causes "internal radiation," resulting in free radicals.<br>
The point is that free radicals abound, and they have an intimate relationship 
with oxygen. Free radicals, because they react with oxygen, may reduce your oxygen 
supply. And reduced oxygen may cause free radical damage.<br>
The exact mechanisms for reduced oxygen vary with the causes. Here are some examples 
of how oxygen resources may be inadequate:<br>
<br>
(1) There may be a deficiency of oxygen supplies. You're just not getting enough 
oxygen to meet your needs.<br>
(2) You may have disturbed oxygen utilization. Something has gotten in the way 
of your use of oxygen.<br>
(3) Because of damaged electron flow, oxygen may not be transported properly. 
This phenomenon is not entirely understood, but we know it happens.<br>
<br>
The ultimate consequence is the same. As so eloquently stated by R. B. Hill in 
Pathobiology and Disease, "It is the reaction to injury, not the injury itself, 
that produces the manifestations of disease."' Again I want to emphasize that 
reduced oxygen appears to be the common denominator in many disease states. And 
once again, it is the reaction to injury, not the injury itself, that produces 
the disease state -the cellular death. Germanium may help to alleviate oxygen 
depletion.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="2-4"></a>Antioxidants<br>
</font><br>
Not every toxin taking a trip through your blood stream affects your cellular 
health. You do have a built-in protection system. Antioxidants are compounds or 
enzymes that oppose the enemy. (Among the antioxidants are: vitamins A, C, and 
E; the minerals selenium and zinc; and the enzyme SOD, super oxide dismutase.) 
You need antioxidants for guard duty - to control the oxidative reactions that 
burn food and create energy. It is when the two conditions - the free radicals 
and the antioxidants - are out of balance, thatproblems arise. that's when cells 
cannot operate in the normal fashion of healthy aerobic respiratory metabolism.<br>
An antioxidant is like the screen in front of your fireplace. It quenches the 
sparks as they form. If the fire in the fireplace is out of control, the screen 
is useless.<br>
Another analogy of antioxidant free radical metabolism is that of the automobile 
engine and its cooling system. The engine runs on the burning (or oxidation) of 
fuel, creating energy and heat, giving your car power to move. If this process 
is uncontrolled, the engine destroys itself because of the heat it has generated. 
The cooling system keeps the temperature within a normal operating range. The 
oxidative reaction is the burning of the fuel; the antioxidant is the cooling 
system. Balance between these two functions is the critical factor, both for your 
car and for you.<br>
So you see that oxygen is double-dealing. It can be flower or serpent, blowing 
hot and cold, supporting the very life it could destroy. The fireplace can provide 
warmth and comfort, but when the fire is out of control, the house may burn down.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="2-5"></a>The Anaerobic Cell</font><br>
<br>
A cell can, however, survive in the runaway, unhampered growth of cancer cells. 
This is called anaerobic metabolism, as compared with aerobic metabolism. Aerobic 
cells live and grow in the presence of oxygen in an orderly, controlled pattern. 
Anaerobic cells grow in an uncontrolled pattern. Oxygen deprivation is considered 
to be its prime cause. The oxygen deficit leads to the anaerobic metabolism that 
sets the stage for malignancy.<br>
The processes involved may have been initiated by inflammation or damage resulting 
from antioxidant deficits, but, regarless of cause, they require additional oxygen. 
It's a Catch-22 situation. Cellular oxygen consumption is increased, depleting 
your supply just when you need it most. Damage may extend to your cell's nutrient 
transportation system, increasing the potential for nutrient deficiencies. Precancerous 
conditions are now in motion. Lack of cellular oxygen may be a major contributing 
factor to malignancies.<br>
Otto Warburg, Nobel prize winner, was the very first to suggest that lack of oxygen 
is the property of cancer cells that distinguishes them from normal cells. He 
said, "Cancer, above all other diseases, has countless secondary causes. But even 
for cancer, there is only one prime cause. Summarized in a few words, the prime 
cause of cancer is the replacement of the respiration of oxygen in normal body 
cells by (the abnormal process of the cancer cell)." Szent Gyorgyi also viewed 
cancer as originating from insufficient availability of oxygen.'<br>
If cancer development is hampered in the presence of normal oxygen metabolism, 
organic germanium may be the supplement of choice as a cancer preventive. (See 
medical studies in Chapter 3 that support this concept.)<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="2-6"></a>Vitamin O: The Oxygen Nutrient</font><br>
<br>
No nutrient - whether it is protein, fatty acid, vitamin, or<br>
mineral - fulfills its functions in its original form. Nutrients are<br>
mechanical substances necessary for converting the dormant or<br>
potential energy in your foods into usable energy for living For this<br>
conversion to take place, oxygen is utilized. The process is called<br>
oxidation: the combining of a food substance with oxygen to release<br>
the stored chemical energy. The nutrients provide the fuel for this<br>
process, which is analogous to burning.<br>
Because of its importance, we have actually dubbed oxygen vitamin O, the oxygen 
nutrient. It is the single most necessary substance for living; we can't live 
for more than three minutes without it. Oxygen even fits the definition of a vitamin, 
which is a substance found in foods (or the environment, like vitamin D) and necessary 
for life, but not usually manufactured by your body. So now you can add another 
nutrient to the vitamin alphabet mix: vitamin O, the oxygen nutrient, the very 
spark of life.<br>
Dr. Stephen Levine points out that complex carbohydrates have 16 parts of oxygen 
and only 14 parts of carbon and hydrogen, or, says Dr. Levine, "more than half 
of a complex carbohydrate is oxygen, but the percentage of oxygen in fats is less 
than 10 or 15 percent, so fats are very low in oxygen. In fact, fats are oxygen 
robbers because they require so much oxygen to be metabolized.<br>
"Protein is composed of 20 to 50 percent oxygen, depending on the specific amino 
acid profile. It is obvious that complex carbohydrates have the most oxygen," 
concludes Dr. Levine. So complex carbohydrates are high oxygen foods. Complex 
carbohydrates are vegetables, whole grains, seeds, and nuts. (Note that fruits 
are not included in this list. Fruits contain high amounts of simple sugars, and 
therefore should not be classified as complex carbohydrates.)<br>
The consumption and quality of complex carbohydrates in the late twentieth century 
have been drastically reduced. This falling in our foodways system and eating 
habits may be a major contribution to cellular oxygen deficiency, and the reason 
why organic germanium is proving w be so beneficial. Even if the quantity of complex 
carbohydrates in the diet is sufficient, quality is of utmost importance. The 
physical form of a food alters its nutrient advantages. When peanuts are ground, 
there is a significant loss of some nutrients plus the possibility of peroxidation. 
In the nut butter form, overabsorption of fat is another potentially dangerous 
consideration. An apple is ingested more than ten times faster in the form of 
extracted apple juice than when it is contained within the fibrous architecture 
of the whole apple. In the form of apple sauce, it is swallowed nearly three times 
faster. In addition to faster digestion, other consequences are decreased satiety 
and disturbed glucose (sugar) balance. These irregular disturbances foster unfavorable 
"overnutrition" and open the doors for more peroxidation (more free radicals) 
and/or less efficient cell metabolism.'<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="2-7"></a>Oxygen and the Athlete</font><br>
<br>
The first response to exercise is a depletion of glycogen from muscle. The American 
Journal of Clinical Nutrition reported a study showing that 48 hours after exercise, 
the complex carbohydrate diet results in significantly higher muscle glycogen 
levels than a simple carbohydrate diet. Another study described in Acta Physiologica 
Scandinavica demonstrated that the capacity to perform heavy exercise increases 
300 to 400 percent when the preceding diet is changed from a low carbohydrate 
diet to one comprised of high complex carbohydrates. This explains the value of 
carbohydrate loading (eating large quantities of complex carbohydrates) by marathon 
runners before a race.<br>
Increased glycogen stored in muscles is associated with high carbohydrate diets. 
The most fundamental limiting factor for performing athletes is cellular access 
to oxygen. The object of exercise is to improve those organs and systems involved 
in your body's processing of oxygen in your heart, lungs, and blood vessels. Again, 
it's a two-way street. You require oxygen to exercise, and exercise is needed 
for better oxygen utilization.<br>
The first articles extolling the virtues of complex carbohydrate diets appeared 
in sports journals. It may be that organic germanium will be a preferred supplement 
for athletes.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="2-8"></a>Oxygen and Longevity</font><br>
<br>
Dehydration among the elderly is a frequent and serious problem. Although average, 
it is definitely not normal. (The solution may be simple. Grandma and Grandpa 
should drink more water. Water is 85 percent oxygen.) For better oxygen metabolism 
in general, organic germanium may be very helpful.<br>
Toxic chemicals such as pesticides, herbicides, hydrocarbons, and solvents are 
largely fat-soluble and reside in fat tissue. When you cat a high fat diet, you 
inevitably consume quantities of these fat soluble toxins and require the utilization 
of more oxygen to metabolize them. Complex carbohydrate foods are usually lower 
in toxins. Although they should be considered the select foods for everyone, they 
are especially imperative for older people. No wonder a diet regimen high in complex 
carbohydrates has recently been referred to as oxygen nutrition.<br>
An extensive thirteen-year study measuring parameters associated with long life 
was reported in the Journal of Chronic Diseases. Respiratory capacity - that is, 
how much oxygen you are able to breathe in - proved to be more significant for 
longevity than tobacco habits, insulin metabolism, or cholesterol levels. The 
longer you've lived, the more dangerous free radical accumulation you may have. 
Free radicals cause age pigment accumulation that result in brownish "age spots" 
on your skin. Once again, organic germanium may provide a longevity bonus.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="2-9"></a>More Consequences of Oxygen Deficiency</font><br>
<br>
According to Dr. Levine, most of us do not consume sufficient oxygen in our day-to-day 
living. He explains examples and consequences of oxygen deficiencies:<br>
(1) An acidic condition, caused by the accumulation of acidic byproducts, occurs 
in poorly oxygenated cells. Consumption of soft drinks, caffeine, and too much 
fatty red meat leads to systemic - or whole body - acidity. When cells are deprived 
of oxygen, lactic acid accumulates and the cellular environment becomes acidic. 
This reduces available oxygen for the primary function of metabolism because more 
oxygen is required to neutralize the acid.<br>
(2) People who gasp for air after minimal exercise demonstrate poor oxygen nutrition.<br>
(3) Common yeast infections (candida albicans) occur frequently in an oxygen-poor 
body. Because of the low oxygen environment, the candida albicans generate a substance 
that is responsible for cellular damage. This disrupts intestinal absorptive processes 
and impairs the function of lymphocytes and red blood cells, thereby reducing 
immune defense.<br>
(4) Frequent use of drugs, whether recreational or prescribed, deplete cellular 
oxygen because oxygen is required to metabolize most toxic chemicals.<br>
(5) Indoor environments often become oxygen-depleted as a result of air pollution, 
insufficient ventilation, or overinsulation to reduce energy costs.<br>
(6) Acute allergic reactions often require oxygen by mouth. But inhalation of 
oxygen is only a short-term solution for an oxygen-deficient lifestyle. Repeated 
and continued use of concentrated oxygen mixtures eventually damage delicate lung 
tissue.<br>
(7) Cells that become cancerous have lost their ability to utilize oxygen. They 
have been oxygen-starved so long that they undergo a metabolic shift and revert 
to ancestral metabolism without oxygen (anaerobic metabolism, as described earlier). 
This is the ultimate and last stage of degeneration caused by low oxygen lifestyle. 
People who consume very high quantities of fat have a far greater incidence of 
cancer as well as other degenerative diseases."<br>
It is unrealistic to assume that the population in general will no longer reach 
for bags of oil-soaked potato chips, feast on artificially-fattened steak, snack 
on high-calorie ice cream, or nibble cheese and crackers through an evening of 
TV-viewing. The metabolism of dense compounds such as fat and protein requires 
extra oxygen. On such diets, less oxygen is available for active muscle tissue 
and for optimal cellular health.<br>
The algae that consume carbon dioxide and release oxygen have been decreasing 
in our lakes and oceans. Increased toxins and pollution, less algae, and SAD - 
the Standard American Diet place cellular oxygen deficiency at risk. Organic germanium 
may be one answer.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
 <br>
</font> 
<hr noshade>
<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><br>
<br>
<br>
<br>
<b><a name="3-1"></a>Chapter 3</b><br>
<br>
<font color="#C11D00">VALIDATION OF ORGANIC GERMANIUM: USES IN MEDICINE</font><br>
<br>
The use of germanium is well-established in Japan, with many case histories cited 
in medical literature. Reports indicate that germanium has been helpful in treating 
a broad range of problems, including liver disease, hepatitis, cancer, leukemia, 
cataracts, and heart ailments. If this sounds as improbable as snake oil, let's 
stop for a moment and note the list of functions for which the isolated form of 
vitamin C can boast. Ascorbic acid plays a role in antibody production. It inhibits 
the growth of viruses. It has a protective effect by lowering histamine concentrations. 
Vitamin C reduces cholesterol in those who have abnormally high levels. The list 
goes on. Some nutrients, like vitamin C and germanium, appear to work overtime.<br>
Although the Japanese are convinced of the manifest benefits of organic germanium 
(they keep Dr. Asai's clinics very busy), Americans need to be educated on its 
behalf. We have ignored germanium just as we have scorned the substances which 
harbor it. Many are unaware of the values of herbs or adaptogenic healing substances 
in this country. (Adaptogens are nontoxic substances which help us to adapt in 
a nonspecific way to life's stresses whether chemical, emotional, physical, or 
biological. This concept is explained in more detail later on.) Do you have friends 
who consume boxthorn seed? Wisteria knob? Probably not. And if you are a garlic 
fancier, chances are it's not because you know it's healthful. We don't understand 
very much about herbs in this country. Americans are not usually adventurous about 
consuming products that are unfamiliar. We certainly don't trust anything that 
hasn't received the acid test of double-blind trials. Even though most medical 
breakthroughs commence with anecdotes and empirical observation, we demand expensive 
scientific research before widespread use becomes the order of the day.<br>
In spite of these requirements, a physician in San Diego uses organic germanium 
both orally and intramuscularly to relieve the problem of impotency. A doctor 
in New York considers it an obligation to offer it to most of her patients. A 
Philadelphia physician uses organic germanium as part of a varied immune protocol. 
A scientist in San Francisco takes a few fifty-milligram capsules when he wants 
to stay up late and work with a clear mind. A plumber in Alaska, suffering from 
AIDS, was unable to work for three months. On large doses under doctor's care, 
he was able to return to work in three days. A woman in Kansas was so lethargic 
she could only drag around in her housecoat all day. After organic germanium treatment, 
she was out in her yard in a week and shopping soon after that. Another woman 
all but eliminated serious radiation burns on her abdomen after several months 
on organic germanium.<br>
The Department of Microbiology at the University of Texas Medical Branch, in cooperation 
with the Virology Division of Shriners Burns Institute in Galveston, Texas (and 
the Department of Microbiology, Kumamoto University Medical School in Kumamoto, 
Japan) published a paper called, "The Importance of TCells and Macrophages in 
the Antitumor Activity of Ge-132 [Organic Germanium]." The results of the reported 
studies demonstrate that the compound confers antitumor activity through immune 
defense mechanisms.<br>
Fortunately for many sick Americans (and many Americans are sick), organic germanium 
has come into its own; science has confirmed what Dr. Asai knew for many years. 
Although Dr. Asai could only theorize about how it is effective, he knew that 
it was effective. Dr. Asai, through his ingenious intuition, has "wooed nature 
and discovered one of its healing agents." Because oxygen plays such an important 
role in immune function, germanium is used extensively in Japan to treat conditions 
associated with oxygen deficiency.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="3-2"></a>Studies Confirming Benefits of Organic 
Germanium</font><br>
<br>
* The Clinical Report (Kiso to Rinsho, in Japanese) 7 (1978):719. Organic germanium 
was correlated with lowered blood pressure in test animals. Similar results were 
also reported at the Proceedings of the Japan Cancer Association, 38th Annul Meeting, 
Tokyo, Japan, 1979, p.112.<br>
<br>
* The Journal of Interferon Research 4 (1984):223-233.<br>
Organic germanium restores the normal function of T cells, B lymphocytes, antibody-dependent 
cell toxicity, natural killer cell activity, and numbers of antibody-forming cells. 
Studies indicate that this compound has unique physiological activities without 
any significant toxic effects. Organic germanium has the ability to modulate alterations 
in the immune response.<br>
<br>
* International Archives of Allergy 63 (1980):338-339.<br>
Organic germanium is considered to restore the impaired immunoresponses in aged 
mice.<br>
<br>
* Mutation Research 125 (1984):145-151.<br>
Germanium works as a potent antimutagen induced in Salmonella. Antimutagenic effects 
were noted in bacteria.<br>
<br>
* Asai Germanium Research Institute, Tokyo, Japan, 1984.<br>
Organic germanium protects against bone-mass decrease in osteoporosis.<br>
<br>
* Microbiology and Immunology 29, 1985:65-74.<br>
Positive effects of oral administration of organic germanium are mediated by the 
inducement of interferon.<br>
<br>
* Proceedings of the Japan Cancer Association II, annual Meeting, 1979, p. 193.<br>
Germanium compounds work as a significant interferon-inducing agent.<br>
<br>
* Tokyo Electric Hospital of Ophthalmology, Dr. Akira Ishikawa. Eye manifestations 
are closely related with systemic diseases. Decrease in retinal blood pressure 
was observed with administration of organic germanium. (This was the first report 
of the use of organic germanium in the field of ophthalmology.) It is also effective 
in the treatment and prevention of essential hypertension and diabetes by effecting 
a normalization of the body state.<br>
<br>
* Japan Experimental Medical Research Institute, Tokyo, Japan. When administered 
to test animals with normal blood pressure, the use of organic germanium shows 
no change. When given to test animals with high blood pressure, the animals returned 
to normal within 7 to 10 days. The compound has lasting effects for a considerably 
long period after it is discontinued. This is typical of adaptogenic substances.<br>
<br>
* Journal of Pharmacological Dynamics 6 (1983):814-820.<br>
Organic germanium has been shown to enhance morphine analgesia in both oral administration 
and injection. It appears to act by increasing the activity of morphine at the 
receptor sites, and by releasing self-made endorphins (the morphine-like substances 
manufactured by humans).<br>
<br>
* Cancer and Chemotherapy 6, in Japanese, (1968):79-83. Organic germanium demonstrated 
antitumor activity.<br>
<br>
* Gan To Kagaku Ryoho 12, December 1985:2345-51.<br>
A remarkable prolongation in life span is observed after oral administration of 
organic germanium.<br>
<br>
*Anticancer Research 6, March-April 1986:177-82.<br>
Organic germanium administered to test animals with tumors resulted in the inhibition 
of tumor growth.<br>
<br>
* Gan To Kagaku Ryoho 12 November 1985:2122-8.<br>
Organic germanium-treated test animals showed an inhibitory effect against certain 
tumors in such a way that suggests that the effect is the result of macrophage 
activity. (Macrophages are part of the immune system. They attack the enemy.)<br>
<br>
* Anticancer Research 5, Sept.-Oct. 1985:479-83.<br>
Testanimals were inoculated with carcinoma or leukemia cells, and then treated 
orally with organic germanium. The study demonstrated that the effect of the organic 
germanium works through the body's defense mechanisms (including macrophages and/or 
Tcells) rather than attacking the cancer itself.<br>
<br>
* Gan To Kagaku Ryoho 13, Aug. 1986:2588-93.<br>
This study suggests that organic germanium is useful for antitumor combination 
immunochemotherapy. The results are an inhibition of tumor growth, enhanced anti-metastatic 
effect, prolonged survival time, and recovery of lost body weight caused by chemotherapy.<br>
<br>
* Tohoku Journal of Experimental Medicine 146, May 1985:97.<br>
The antitumor action of organic germanium appears to be related to its interferon-inducing 
activity.<br>
Most of these citations are reports of controlled studies. Dr. Asai and physicians 
around the world have been using organic germanium in reallife situations. In 
addition to the disappearance of serious illness, patients have lost warts, corns, 
and deeply imbedded splinters. Longstanding headaches and backaches disappear. 
People report the healing of eczemas and similar minor and major ailments. Other 
reports show that frequent urination is corrected, and organic germanium has proved 
to be an easy and effective way to reduce fatigue.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="3-3"></a>A Few More Reports</font><br>
<br>
Dr. Anderson of Mill Valley, California, reported at a recent meeting of the Orthomolecular 
Physicians that he cured a patient who had diverticulitis (inflammation related 
to colon pouches) for five years. The patient, under Dr. Anderson's supervision, 
received 500 milligrams of organic germanium a day along with vitamin C and other 
orthomolecular modalities. The results impressed Dr. Anderson and thrilled the 
patient. Another physician reported that she herself suffers from food allergies, 
but when she takes organic germanium she can "cheat" without ill effects. Yet 
another physician reported that organic germanium is powerful in the control of 
candida, and that the resulting sense of well-being exceeds that of any other 
medication. It was also reported that one-third of those with sleeping problems 
have been relieved of their difficulties.<br>
The Journal of Microbiology and Immunology has recently confirmed that organic 
germanium compound promotes increased interferon production. This may be why it 
is effective in attacking viruses. Interferon induction is considered by some 
of the researchers to be the starring role of germanium.<br>
The International Archives of Allergy and Applied Immunology demonstrates how 
germanium has helped the restoration of impaired immune responses in aging test 
animals. In a study of more than two dozen post-surgical patients, it was shown 
that blood returned to normal with greater speed with the use of germanium.. And 
surgeons may also be interested in its analgesic effect: it enhances the pain-killing 
effects of morphine. (Dr. Howard Bezoza, a New York surgeon, has stated that aloe 
is probably the best local anesthetic around. As already noted, aloe contains 
a significant quantity of germanium. Isn't it intriguing how the nutrition puzzle 
pieces fit together?)<br>
An international AIDS treatment conference was held in Tokyo, Japan, on the 13th 
and 14th of February, 1987. Six substances were authorized to be used intensively 
for clinical testing. They were selected on the basis of reported success in the 
treatment of disease over a period of time, and have been confirmed to have low 
toxicity. Organic germanium is one of the six, chosen primarily for its antiviral 
action.<br>
Today, many trials and studies testing the therapeutic value of organic germanium 
are in progress. Most of them involve its use with cancer, and most of them are 
being done in Japan.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
 <br>
</font> 
<hr noshade>
<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><br>
<br>
<br>
<br>
<b><a name="4-1"></a>Chapter 4</b><br>
<br>
<font color="#C11D00">HOW ORGANIC GERMANIUM MAY WORK TO MAINTAIN OR RESTORE HEALTH</font><br>
<br>
The intricate nuances of metabolic pathways involved in health and disease are 
not fully understood. Scientific studies that focus on substances which encourage 
a person's self-healing potential reveal only that something barely explicable 
happens on a cellular level. Although theories abound, there is no unified agreement 
as to what that force may be.<br>
Despite the lack of understanding, the capacity for repair and health maintenance 
is greater than most people realize. As stated, one substance that appears to 
promote that capacity is organic germanium. Again, organic germanium has a reputation 
for enriching your body's oxygen supply. It is theorized that this is its major 
force. The substance itself does not cure.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="4-2"></a>Organic Germanium as an Adaptogen</font><br>
<br>
When a chemotherapeutic agent is added directly to cancer cells in a test tube, 
the cells are destroyed. When organic germanium is added to cancer cells in the 
same manner, the cells exhibit no change. The germanium appears to be relatively 
ineffective. But organic germanium indirectly stimulates anticancer defenses. 
Although organic germanium doesn't cure, it appears to enhance your body's metabolic 
ability to do so.<br>
In the case of cancer, it doesn't kill the cells, but stimulates your immune defenses 
to produce those substances which will, in turn, help to destroy the antagonist. 
Among its functions is its ability to boost the production and/or efficiency of 
natural killer cells. (See Chapter 3 for detailed studies.)<br>
<br>
Substances which help to normalize body functions indirectly are known as adaptogens. 
An adaptogen is classified as nontoxic and having a nonspecific effect, enhancing 
your ability to copewith any stress (physical, emotional, or chemical) as needed. 
Organic germanium has been reported to normalize acid/alkaline values, glucose 
curves, cholesterol levels, and blood pressure rates.<br>
In true adaptogenic fashion, studies show that organic germanium has little effect 
on normal and young test animals, but significantly augments the immune response 
in aged animals. The immune response normally decreases with age. Organic germanium 
may help to retard this process. It should also be noted that it's not that difficult 
to breed healthy test animals. In today's polluted world, however, not too many 
humans enjoy total, optimal health at any age.<br>
Adaptogens differ from drugs in several ways:<br>
<br>
(1) No prescriptions are necessary. They answer the need for those who ask, "What 
can I do at home so that I won't have to go to the doctor, or reduce the deleterious 
effects<br>
of the drug treatment prescribed for me?"<br>
(2) They are user-friendly. No high-tech equipment, needles, syringes, or professional 
expertise are required for use.<br>
(3) They are less costly than most drugs.<br>
(4) They are not habit forming.<br>
(5) A drug continues to work even after a state of normalcy is achieved. An adaptogen 
regulates, and is held in abeyance when the challenge ceases to exist.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="4-3"></a>Organic Germanium As An Oxygen Enhancer<br>
</font><br>
It is no news to the physician working with alternative therapies that the right 
kind of supplements have been known to enhance the function of oxygen in cells 
and tissues. Nutrients fine-tune metabolism and can often make the difference 
between health and disease for anyone struggling with a highly stressed lifestyle. 
Cells use oxygen to perform their various functions. The life of your cells rules 
the health of your body.<br>
Organic germanium may work as a catalyst, rather than a substitute, for oxygen. 
For reasons not yet understood, it has an oxygen sparing effect: it has been shown 
to lower the requirement for oxygen. The single most important substance for life-oxygen 
- may be the most powerful immune-stimulant of all.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="4-4"></a>Organic Germanium as Detoxifier</font><br>
<br>
Another role of organic germanium is that of detoxifier: it helps your body to 
expel pollutants. Because of the chemical structure of this immune-stimulating 
oxide, it tends to bind or chelate (grab), and then remove toxic compounds- and 
harmful substances. The chelating effect renders germanium especially helpful 
for mercury, cadmium, and similar metal poisonings. This fact should be of interest 
to everyone in general (we are almost all subjected to mercury toxicity because 
of dental fillings), and to smokers in particular (smoking causes high cadmium 
toxicity).<br>
Because of its chelating effect, it is believed that organic germanium functions 
as an antioxidant as well as an oxidant.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="4-5"></a>Organic Germanium and the Body Electric</font><br>
<br>
The fact that our bodies can generate electricity was proved in the eighteenth 
century. With the advent of high technology, we can now evaluate health states 
by measuring various electrical waves. Studying electrical impulses in your brain, 
for example, helps to discern whether or not your brain is functioning normally. 
The test that uncovers this information is in widespread use, and is called an 
electroencephalograph (EKG). When brain tumors are present, variations from the 
normal brain waves announce their presence. The same is true of heart and muscle 
areas. Measurements of electrical output can determine just how healthy you are. 
Delta waves are recorded in people who are enjoying a good, deep sleep.<br>
And we are all familiar with static electricity sparks that fly out or seem to 
sizzle when we brush our hair, or walk across a carpeted room under certain conditions.<br>
If we had no electricity in our bodies, we couldn't use these parameters as health 
gauges. One theory thatexplains thebeneficial effects of organic germanium centers 
around the need for your body's electricity to be in balance. Organic germanium 
is believed to help your body discharge unwanted electrical current, and to allow 
much needed current to flow through, thereby establishing the desired electrical 
balance.<br>
Dr. Levine describes the role of oxygen as it relates to your electrical energy. 
He says, "Like the electrical circuits in your home, your body is also electrical. 
Oxygen forms the positive terminal of your cellular battery. Energy from fresh 
natural foods provide the current. Trace minerals, like selenium, zinc, iron, 
and manganese provide the wiring for the flow of electrical energy. Insulating 
material must coat and protect the energy transport machinery. For life, there 
must be a continuous flow of electricity, and adequate oxygen to draw the current."<br>
It is predicted that energy medicine is the medicine of the future.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="4-6"></a>Organic Germanium and Hypoxia</font><br>
<br>
Hypoxia is a serious condition that occurs when oxygen supplies to cells and tissues 
are depleted. Symptoms of aging resemble symptoms of hypoxia. If we can bring 
more oxygen to tissues, can we forestall mental function decline that occurs so 
frequently in older people? Organic germanium has been reported to increase mental 
capacity.<br>
Nothing is ever black or white. The shades of gray between very serious illness 
and optimal health, or between total senility and minor mental failures, may be 
correlated with the degree of oxygen supply. In addition to decreased mental function, 
other symptoms associated with the development of hypoxia are fatigue, acidosis, 
weakness, and increased susceptibility to infection.<br>
Physicians report that skin takes on a healthy pink color after organic germanium 
therapy (even in those areas of the body that had suffered from poor circulation), 
and patients report that they feel as though enveloped by a warm glow, a sense 
of special well-being. It is believed that the enzyme which inhibits the normal 
production of endorphins- your body's natural, homemade morphine-is in turn inhibited 
by organic germanium. Therefore, the high spirits and verve. Organic germanium 
functions well at human body temperature. As temperature rises, the germanium 
current appears to flow more efficiently.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="4-7"></a>Organic Germanium and Immunity</font><br>
<br>
Interferon production is enhanced when organic germanium is used as a supplement 
in immune-compromised people of all ages. The metabolic pathway involved in the 
increase of interferon may be its ability to normalize lymphocyte cells, which 
are important in the production of antibodies. (An antibody protects against antigens, 
which are harmful toxins.) Organic germanium converts inactive marcrophages important 
immune cells - to activated ones. It increases natural killer cells, brings blood 
hemoglobin levels up, and white cell counts down.22 These are some of the functions 
we are aware of. The researchers believe they are just at the tip of the iceberg. 
As we learn more about immunity, we should come closer to understanding precisely 
how organic germanium works.<br>
Our knowledge of organic germanium increases daily. At this very time, a few dozen 
studies are underway in major hospitals, clinics, and laboratories.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="4-8"></a>Organic Germanium and the American Tradition</font><br>
<br>
A nonspecific medical paradigm doesn't fit our medical milieu. We are inclined 
to measure values with increasingly delicate instruments in ever more high-tech 
ways to arrive at more and more exact figures. Anything that doesn't fit this 
mold is regarded as mystical. Although the manner in which adaptogens may effect 
cures lacks western scientific explanation, their success does not depend on miracles, 
nor is it a total mystery. We are coming closer to understanding the metabolic 
pathways involved.<br>
The use of adaptogens is not old-fashioned, but it is undeniably old. Our scientific 
community is not kind to ideas that conflict with "modern" ones. Too often, techniques 
that don't fit basic understanding are abandoned, even if they seem to work. Although 
research on organic germanium has been excellent, the results and the concept 
fly in the face of American medical judgement.<br>
The Japanese are far ahead in recognizing the value of organic germanium. This 
may be because the Asian medical system traditionally considers the strength (or 
lack of it) and physical characteristics of the specific patient. Symptoms are 
interpreted on the basis of a patient's total condition, even when an illness 
appears to be pinpointed - such as a red throat. This does not correspond with 
the dissection to smaller and smaller and smaller as used in medical practice. 
We diagnose, give the sickness a name, and medicate for the masses. A sore throat 
is a sore throat is a sore throat, and we do not consider different or total physical 
makeup. Meanwhile, the number of illnesses that are not responding to such highly 
specialized medicine is on the increase.<br>
But no concepts have grasped the imagination of the American public in recent 
years as compellingly as the ideas that we can be responsible for our own health, 
or that the body has amazing curative powers if given a chance to heal itself. 
The time has come for our medical community to complement its technical advances 
with self-healing forces and the substances which promote those forces - even 
as the common denominator of healing remains elusive.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
 <br>
</font> 
<hr noshade>
<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><br>
<br>
<br>
<br>
<b><a name="5-1"></a>Chapter 5</b><br>
<br>
<font color="#C11D00">External Applications of Germanium To Relieve Stress and 
Pain</font><br>
<br>
What is the unseen energy that spills over from one object or one person and affects 
another? How can we explain the electrical currents that exist in parts of the 
nervous system? What gives a cell membrane the energy to pump ions back and forth, 
in and out of cells? Why does the semiconductor quality of germanium appear to 
affect areas of injury or pain when applied topically?<br>
At the turn of the century it was shown that when electrical currents pass through 
an aquarium in which larval salamanders were living, their regeneration was speeded.23 
When small negative voltages are applied to groups of neurons, their sensitivity 
increases.<br>
"Currents of injury," emitted from all wounds, were described by A. M. Sinyukhin 
of Lomonosov State University in Moscow. Sinyukhin correlated specific electrical 
events from wounds with biochemical changes. For example, he noted that as positive 
currents increased in damaged tomato plants, the impaired cells more than doubled 
their metabolic rate, became more acidic, and produced more vitamin C than before. 
When small amounts of current were increased with the use of batteries, plant 
restoration occurred up to three times more quickly. Injury currents involve phenomena 
noted in animals as well as plants. Not only are they real, but currents of injury 
vary in proportion to the severity of the wound.24<br>
Robert Becker, M.D., renowned for his work on electromagnetism, discovered that 
the electrical potential of skin reflects the arrangement of your nervous system. 
In the 1920s and 1930s, interest was generated in the idea that direct currents 
guide the growth of cells, especially neurons. In 1946, researchers scientifically 
confirmed the theory. Neuron fibers do orient themselves along a current flow. 
Nonetheless, it took many years for acceptance of this information in the scientific 
community. Human sensations have been correlated with electrical data. It was 
SzentGyorgyi who taught us that the molecular structure of many parts of the cell 
support semiconduction. Although the mysteries of electromagnetism have never 
been fully solved, their existence and complexities are facts of life. These events 
may explain why supporters and ointments containing germanium tabs are proclaimed 
as pain killers.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="5-2"></a>External Applications of Germanium</font><br>
<br>
Germanium is available for external application in the form of ointment, as soft 
tabs woven into fabric supporters, or as metal tabs for band-aid use.<br>
Ointment specially prepared with organic germanium works wonders on skin rashes 
and other skin problems. Although anecdotal, you may be as impressed as I was 
to learn that a dry-lip rash that one of my sons could not shake for two months, 
regardless of effort, disappeared overnight with one application of germanium 
ointment.<br>
Because external applications of germanium tabs appear to relieve muscle pain, 
supporters containing them are available. In Japan, germanium supporters are sold 
in drug stores and are as familiar to the Japanese as Ben Gay is to us.<br>
Small tabs of germanium may be placed on band-aids and applied at acupressure 
points. They have been placed at the tips of the eyes to relieve fatigue when 
driving or sitting in front of computer screens for long sessions. Specialpurpose 
supporters for back pain, tennis elbow, muscle strain, foot aches, and PMS are 
available. The germanium tabs are the same; it is merely the shapes of the supporters 
that vary so they can be worn with ease at the appointed place on your body. For 
example, underpants 1 ined with the tabs have been reported to relieve PMS; knee, 
ankle, leg, thigh, elbow, wrist, arm, and belly bands are said to relieve pain 
in those specifically-stressed areas. You can see how helpful these supporters 
may be for athletes or senior citizens -or anyone with any kind of pain. (I personally 
wear a leg band to relieve lactic acid discomfort when I walk aerobically.) External 
use of the germanium tabs for headaches, stiff necks, bad circulation, and arthritis 
pain have been heralded as beneficial. The tabs themselves remain active indefinitely 
as long as they are not exposed to hot water or automatic dryers.<br>
Because everyone is an individual, with differing electrical charges, the "force" 
or effect varies from one person to another. People report that relief may be 
immediate, or it may take some time. At best, pain is thoroughly eased. At worst, 
there is no harm done: germanium is not a radioactive material, so there is no 
need for concern. In rare cases, pain will increase initially. According to the 
experts, this is a detoxifying reaction, and a sign that the germanium is "working."<br>
The "magic" that penetrates into your skin structure has been conjectured to be 
an electric current that is helping to discharge and to balance. Electric fields 
and energies interact in many complex ways that have given rise to much of the 
natural world, working its wonders unseen and apparently unfelt, and until very 
recently, not understood. As stated, energy medicine is predicted to be the medicine 
of the near future. Using supporters containing germanium tabs may be the prescription 
of tomorrow for the relief of pain and stress. For those interested (or for those 
willing to try a modality on the cutting edge of tomorrow), it's here today.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
 <br>
</font> 
<hr noshade>
<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><br>
<br>
<br>
<br>
<b><a name="6-1"></a>Chapter 6</b><br>
<br>
<font color="#C11D00">Risks and Limits: Toxicity and Safety</font><br>
<br>
No substance can be used safely at any level, not even water. Some, however, can 
be used at higher or lower quantities than average and still remain within safety 
ranges. Nor does every person respond to each and every substance the same way. 
But a true immunostimulant should be able to work for a wide sphere of people, 
in a broad range of amounts, influencing a multitude of cell types. Organic germanium 
is such an immune stimulant.<br>
The term "LD50" is used as a toxicity value. It means thatwhen a substance under 
surveillance is administered to a particular number and breed of test animals, 
50 percent of the animals die at that specific dosage, the LD50. According to 
Dr. Asai, the sesquioxide, or organic, form of germanium is incredibly safe. In 
fact, no toxicity has been discovered at dosages ten times greater than the highest 
dose that Dr. Asai administered. The LD50 for germanium, as demonstrated in test 
animals, is 10 grams per killogram of body weight. Obviously, there are no toxic 
symptoms worthy of particular attention. Researchers have translated the test 
results in animals to ascertain that organic germanium would be safe for humans 
even at tens of grams per day. This is many-fold in excess of any amount that 
any person would ever require. The antioxidant properties of organic germanium 
may contribute to its nontoxic attributes.<br>
Some of the first tests validating the safety of germanium were actually performed 
in this country in the 1960s. Germanium proved to be neither tumorigenic or carcinogenic. 
There were fewer tumors in test animals fed germanium than in the controls .26 
Animals were exposed for their lifetimes to small amounts of germanium, cadmium, 
and several other metals. The substances were added to their drinking water in 
an effort to find out if human diseases could be reproduced. Disease states developed 
only in those given cadmium. It is not surprising that an element like germanium 
that does not accumulate in human tissues with age is not toxic. (Cadmium accumulates 
in kidneys, arteries, and liver, where it interferes with enzyme systems.)<br>
The clinical effects and safety of organic germanium reported by Dr. Asai have 
been confirmed by many studies. Research has been done to test for both acute 
and chronic toxicity. One such study was done at the School of Pharmaceutical 
Science, Kitasato University, Tokyo, verifying Dr. Asai's claims. This report 
shows that organic germanium possesses no toxic properties at conventional levels, 
and almost no toxicity at extremely high dosages. Gross anatomical observation 
of liver, kidneys, spleen, and other organs exhibited no noteworthy changes after 
extremely large amounts of organic germanium were administered.<br>
The Japanese journal Pharmacometrics also reported that the general effects of 
germanium compounds were totally nontoxic, even at very high levels. Furthermore, 
the product was discharged from the body through the digestive tract within 20 
to 30 hours. This is rapid clearance for a substance so powerful, and one reason 
why organic germanium is not considered a drug, but rather a healthgiving product.<br>
Organic germanium is stable against temperature, humidity, and light. No changes 
occur in appearance, content, solubility, and quantity, nor are any decomposed 
products detected when organic germanium is kept at room temperature for 36 months.<br>
Dr. Asai never administered more than two or two-and-a-half grams to patients 
per day, even to those who were extremely ill. As with most nutritional therapeutics, 
any side effects are not serious and disappear either when treatment stops, or 
after treatment has progressed for several weeks. Post-surgical patients treated 
with about two grams of organic germanium daily registered complaints of symptoms 
that were minor, and which disappeared in three weeks. Slight skin eruptions, 
occurring in only about two percent of patients, cleared within a short time.<br>
<br>
Because the skin is a major detoxifying organ, skin eruptions after germanium 
treatment represent the body's reaction to rid itself of toxins. Other avenues 
of discharge are urine and feces. Urination may be increased, and feces may become 
softer, watery, and more frequent. (Unlike diarrhea, there are no abdominal pains.)<br>
Although germanium sesquioxide is the safer variety, even germanium dioxide, the 
nonorganic type, has been shown to be safe at low levels. This is not true at 
high levels, however. The Journal of Toxicological Science reports on accumulation 
of germanium dioxide in the tissues of a long-term user who died of acute renal 
failure . The patient had been taking 600 milligrams of inorganic germanium (germanium 
dioxide) daily for 18 months.<br>
Be assured that the germanium you purchase is verified by the manufacturer to 
be organic germanium - or bis-betacarboxyethyl germanium sesquioxide. Reputable 
manufacturers routinely test expensive raw materials like germanium in their own 
laboratories to verify the chemical structure of the products before final formulation.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
 <br>
</font> 
<hr noshade>
<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><br>
<br>
<br>
<br>
<b><a name="7-1"></a>Chapter 7<br>
<br>
</b><font color="#C11D00">A WORKING PLAN FOR ADDING GERMANIUM TO YOUR DIET<br>
</font><br>
The development of malignancy in a cell is a long-term process, yet it involves 
recent events. For example, lung cancer in smokers is precipitated by exposure 
over many years. However, giving up smoking sharply reduces your risk. No matter 
what your past medical history, or how old you are, making dietary<br>
changes for the better improves life quality.<br>
People who move to new locations often acquire the cancer rates of their new environment. 
For each cancer known in the United States, some society or group elsewhere has 
been successful in avoiding it. This emphasizes the role of diet and environment 
in disease.<br>
An individual's diet is a key factor in the development of even genetically determined 
diseases, according to Dr. Robert Good, formerly of the Sloan-Kettering Institute 
for Cancer Research in New York. Dr. Good believes that dietary modification may 
forestall or even completely prevent development of these diseases and correspondingly 
lengthen and enhance the quality of life.<br>
The effect of diet on health is no longer debated. Vitamins and minerals, plus 
the amount of protein, fats, carbohydrates, and fiber have been found to modify 
the expression of toxicity and carcinogenicity of environmental agents. Slowly, 
the practice of treating such disease with nutritional intervention is becoming 
more popular. Nutritional status helps to explain why some people are susceptible 
to disease while others are apparently spared, even when both are exposed to similar 
toxins. Evidence points to the fact that nutritional status may be improved with 
organic germanium, whether it is ingested in age-old healing agents like Siberian 
ginseng, chlorella, and Reishi and shiitake mushrooms, or in twentieth century 
supplemental form. It is readily absorbed from water, edible plants, and animal 
products.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="7-2"></a>Table Talk</font><br>
<br>
Organic germanium compound is indeed the "new nutrition kid on the block," a landmark 
development in nutritional medicine. If you want to include it in food sources, 
here area few nutrition notes:<br>
Garlic. This pungent herb enhances the flavor of many cooked dishes as well as 
cold salads. Cloves of garlic may be cut into slivers or crushed before being 
added to hearty stews or grain dishes. (To minimize the smell of garlic after 
eating it, chew a sprig or two of parsley, or sprinkle chlorella granules into 
some water, and use as a rinse before swallowing the mixture.)<br>
Ginseng. Ginseng is used occasionally as seasoning; it is more commonly made into 
a tea. Soviet cosmonauts have been issued pieces of ginseng to take on missions 
into space as a preventive against ailments.<br>
Comfrey. Similar to spinach in preparation and taste, comfrey offers excellent 
nutrient value served raw and is delicious when lightly steamed and buttered.<br>
Chlorella. Chlorella granules may be added to a variety of recipes such as salads 
and soups. My favorite company hors d'ouvre is something I call "Green-Marine 
Taco Spread": 2 tablespoons chlorella granules; 2 tablespoons plain yogurt; 1 
clove minced garlic; 1 cube bouillon; 2 tablespoons tamari; 1/2 cup tofu; ground 
pepper; 4 tablespoons sesame seeds. Combine all ingredients and blend well.<br>
A Chlorella Smoothie can be mixed by adding 1/2 tablespoon of chlorella granules 
to 8 ounces of apple juice, 1 or 2 tablespoons of lemon juice, and a few dashes 
of cinnamon.<br>
Watercress. This is a popular salad garnish with a mild but peppery flavor. In 
addition to adding watercress leaves to your salads, try chopping them finely 
to use as seasoning. Or simply place a bunch of watercress in a bowl of water, 
leave it on your kitchen counter, and nibble the leaves through the day.<br>
Purists who eat meat seek only organic meat products. The health-oriented may 
soon be able to purchase germanium-raised organic meat in the near future. One 
organic rancher in Nebraska has started using germanium in animal feed. He claims 
that organic germanium has the same effect as the antibiotics (the animals grow 
fatter faster, and so on), but with the use of germanium, his animals remain healthy, 
if not healthier. Since organic germanium helps detoxification, these animals 
have fewer toxins. Organic-germanium beef may be one solution to the degredation 
of our foodways. The Nebraska rancher believes he can stop the cancer in the meat 
chain.<br>
One company bottles and sells water from Utah's inland sea, the Great Salt Lake, 
because it contains a significant quantity of germanium. Another company grows 
vegetable products hydroponically (in water) in a germanium medium to build up 
the germanium concentration to 800 parts per million. A patent for barley sprouts 
grown with germanium has been obtained in Japan.<br>
Although germanium is believed to be absorbed more efficiently in food form, the 
quantities found in food may be too limited for therapy. Small amounts can, however, 
serve for prevention.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"><a name="7-3"></a>Germanium as a Supplement<br>
<br>
</font>Because germanium occurs in such small quantities in plants, and because 
its synthesis involves a difficult process, the cost of supplemental organic germanium 
may appear to be high when compared with some other supplements. Needless to say, 
you could never get large quantities in food. And like so many other nutrients, 
germanium is lost when foods are grown in tired soils, or when they are processed 
or overcooked. Germanium is present, for example in a whole grain, but not in 
refined flours.<br>
The stability of organic germanium, described in Chapter 6, offers many advantages. 
Like vitamin C, the effective dose spans a wide spectrum. It can be helpful in 
microgram amounts, yet an optimal quantity for cancer or serious infections is 
5 or 6 grams, administered by a physician. And, like vitamin C, it is not stored 
in your body, but is cleared rapidly.<br>
As a preventive measure, 25 or 30 milligrams a day is usually recommended. For 
minor problems, 50 to 100 milligrams daily is more effective. For relief of severe 
pain or for achieving an overall "good" feeling, a gram or gram and a half a day 
may be prescribed. And for those who are seriously ill, a few grams a day may 
be recommended by the physician. (Larger amounts should never be taken without 
consulting a physician.) As stated, Dr. Asai never used more than 2 or 2 1/2 grams, 
and even reported success with 500 milligrams a day. If he could not cure malignancy 
with these amounts, at least the pain of advanced cancer was dramatically reduced.<br>
Serafina Corsello, M.D., of the Corsello Centers in Huntington, New York, says, 
"Because germanium is a powerful stimulator of the immune system, I allow a 'cooling 
off period for very ill patients. This prevents a 'die-off effect. An alternating 
protocol gives the system an opportunity to unwind before the next stimulation 
phase. The recommendation is five days on and two days off. (Take organic germanium 
from Monday to Friday, and none on the weekend.) The sicker the person, the greater 
the response. A sick patient may even get a rash, but the cooling down period 
usually prevents both the die-off effect and other symptoms.<br>
"Work up to prescribed dosages gradually. Very ill people those who experience 
severe fatigue and petrochemical sensitivity - require from 150 to 500 milligrams 
daily.<br>
"It is also advisable to check the adrenals. If the adrenals are not functioning 
properly, you are beating a dead horse."<br>
Although sometimes administered intramuscularly and intravenously, organic germanium 
is very successful when taken orally. The absorption rate is even higher when 
taken sublingually (under the tongue), quickly affecting your lymph and circulatory 
systems.<br>
This method increases absorption by 15 to 20 percent. Nasal application (sniffing) 
is also an efficient method, but some may find that this manner of absorption 
irritates nasal passages.<br>
Smaller amounts of organic germanium are used for lung cancer because of the rapid 
circulation and metabolism of that organ. Only 15 milligrams daily have been demonstrated 
to help those with candida. It has an energizing effect at equally small dosages. 
For more serious illness, frequent and smaller quantities appear to be better 
than larger amounts taken less often.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
<br>
<font color="#C11D00"> <a name="7-4"></a>In Conclusion<br>
</font><br>
These are the first facts about life-sustaining organic germanium, common denominator 
in renowned remedies.<br>
Nutritional supplementation has been accepted as a therapeutic measure in treating 
vitamin-dependency syndromes. Supplementary oxidant/antioxidant administration 
may be just as therapeutic in providing protection against free radicals and oxygen 
deficiencies.<br>
Unfortunately, we cannot always control many factors in our environment. We can, 
however, control the quality and quantity of our nutrition. As the organic germanium 
story continues to unfold, we look ahead to more knowledge and uses for "the new 
nutrition kid on the block" -organic germanium.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a><br>
 <br>
</font> 
<hr noshade>
<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><br>
<br>
<br>
<br>
<font color="#C11D00"><a name="appendix"></a>APPENDIX A</font><br>
<br>
Food Substances Containing Significant Quantities<br>
of Germanium<br>
</font></td>
</tr>
<tr> 
<td width="30%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Herbs<br>
<br>
Shelf fungus<br>
Ginseng<br>
Sanzukon<br>
Angelica<br>
Waternut<br>
Boxthorn seed<br>
Wisteria knob<br>
Pearl barley<br>
<br>
<b>Age-old Remedies</b><br>
Garlic<br>
Aloe<br>
Comfrey<br>
Chlorella<br>
</font></td>
<td width="70%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Parts 
per million<br>
<br>
800 - 2000 ppm<br>
250 - 320 ppm<br>
257 ppm<br>
262 ppm<br>
239 ppm<br>
124 ppm<br>
108 ppm<br>
50 PPM<br>
<br>
<br>
754 ppm<br>
77 ppm<br>
152 ppm<br>
76 ppm</font></td>
</tr>
<tr> 
<td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">* 
Shelf fungus has a history of being an effective treatment for cancer. This was 
cited by Nobel Prize winner Alexander Solzhenitsyn in Cancer Ward.<br>
<br>
<a href="#first"><img src="./img/accept.png" border="0"></a> </font></td>
</tr>
</table>
<script>bottom_round('580','#F9F9F9');</script>	
		</td>
	</tr>
</table>
<br><br><br>
			</td>
		</tr>
	</table>
	<br>




<?
	include "./include/inc_bottom.php";
?>