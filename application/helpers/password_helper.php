<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ShareCode
 *
 * 
 */

// ------------------------------------------------------------------------

function generateRandomPassword() {

	static $words = array('notepad','about','above','absent','according','achain','achieves','across','actually','added','advantage','affect','after','again','aihas','aijand','akand','algorithm','algorithms','allow','already','although','always','among','analysis','another','answer','appear','applicable','approach','approximation','arguing','argument','arises','assembly','assignment','associate','assume','assumption','assured','attributed','automobile','automobiles','axioms','basic','because','before','behind','being','bernoulli','bestated','better','between','binary','binomial','bitonic','boole','bottom','bound','bounds','brand','bridges','briefly','brute','build','built','bydifferent','called','cannot','cantor','cardinality','certain','chain','chances','change','chapter','characterize','chassis','child','children','choice','choices','choose','choosing','claim','clause','clauses','cleaner','cleaners','close','closed','cnfsatisfiability','coefficients','coins','colonel','column','columns','combination','combinations','combining','comes','compatible','compendium','complement','complete','completed','compute','computed','computing','concern','conditional','conquer','consequently','consider','considered','consist','consisting','consists','constant','constrain','construct','contain','containing','contains','contestant','continuous','contradicting','contradiction','contrast','conversely','copies','corporation','correct','correctness','correspondence','corresponds','costs','could','countable','counting','created','cross','current','curtain','curtains','customer','cutting','decomposition','define','defined','defines','definition','definitions','degree','denote','denoting','depth','deriving','design','detail','determinant','determine','determined','determining','deterministic','development','different','difficult','dimension','dimensions','distinct','distinguishable','distinguishes','distribution','distributions','divide','divided','dividing','domains','dominated','during','dynamic','efficient','effort','eifor','either','element','elementary','elements','emcee','empty','ensue','enter','enters','entries','entry','enumerating','equal','equally','equals','equation','equations','equivalent','essential','euler','evaluates','evaluating','event','events','every','exactly','examined','example','except','exception','exchange','exchanged','exclusive','executed','exercise','exercises','exits','expand','expected','experiment','explain','explicitly','exponential','express','expressed','extended','factory','failure','failures','faster','fastest','feels','fewer','figure','figures','finding','finished','finite','first','flipping','flips','focused','following','follows','forbidden','force','forming','formula','formulas','found','fully','function','further','general','generalized','generally','generates','generating','given','going','graph','greater','guarantee','guard','guildenstern','halves','happier','harary','having','heads','height','hidden','holds','however','identities','identity','illustrate','illustrates','important','impossible','incurred','indeed','independent','index','infeasible','infinite','information','ingredient','input','instance','instead','integer','integers','interest','internal','intersection','interval','introduced','intuitively','inverting','investigate','involving','jreferences','kinds','knowing','knows','labeled','labels','large','latter','leads','least','leaves','leibniz','lemma','lifted','lifts','likely','likin','limited','linear','lines','literals','little','logic','longer','longest','looked','lookup','lower','makes','making','manager','manufactured','manufacturing','mathematical','mathematics','matrices','matrix','maximization','maximizes','means','merely','minimize','minimizes','minimizing','missing','modern','modified','motors','multi','multiplication','multiplications','multiplied','multiply','multiplying','mutually','nature','nbinary','necessary','needed','negation','negligible','nested','network','nodes','nonoptimal','nonsingular','nonzero','normalize','normally','notable','notations','noting','nsuch','number','numbered','obtained','obtaining','obvious','occasionally','occur','occurs','ofamatrix','often','onigsberg','operation','operations','opportunity','optimal','optimally','optimization','order','ordered','orders','original','originated','other','others','ourtabular','outcome','outcomes','overlapping','parenthesization','parenthesizations','parenthesize','partially','particular','partition','parts','passes','paste','pasting','paths','perform','performs','period','permutation','permutations','picked','pioneered','place','point','points','polynomial','position','positional','positioning','positions','positive','possible','preceding','presented','preserve','preserves','prevents','primarily','prison','prisoner','prisoners','privately','prize','probabilistic','probabilities','probability','problem','problems','procedure','produce','produces','product','products','professor','programming','progresses','progressively','properties','property','prove','proved','provide','pseudocode','published','quantity','quickly','random','randomized','randomly','rather','ratio','reals','reason','recall','recurrence','recursion','recursive','recursively','reexamine','refer','reference','referring','regarding','regions','remainder','remaining','remove','rendered','replacing','require','required','requirement','resources','respectively','resulting','results','return','reveal','revealing','reviews','revisits','right','roles','rosencrantz','sample','satisfiability','satisfiable','satisfied','satisfies','satisfy','scalar','scheduling','second','section','select','selection','sense','sequence','sequences','setting','seven','several','shall','share','shortest','shorthand','shortly','shown','shows','significant','similar','simple','simultaneously','since','singular','situation','small','smaller','solution','solutions','solve','solved','solves','solving','sometimes','somewhere','sorter','sorts','space','spaces','special','splice','splicing','split','square','stage','standard','starting','station','stations','status','still','stored','storing','strings','subproblem','subproblems','subset','subsets','substructure','success','successes','suitable','suppose','supposing','supposition','switch','symbolic','table','tails','takes','taking','technique','technologies','tells','terminates','terms','thematrix','themselves','theorem','theoremc','theorems','theory','there','therefore','these','those','three','through','thumb','times','together','toillustrate','total','transfer','transformation','treat','trees','trials','triangular','tried','triply','typically','unavailable','unchanged','uncountable','uncountably','under','unfortunately','uniform','union','unless','unlikely','unrolled','unweighted','update','upper','useful','using','usually','value','variable','variables','varies','verify','vertex','vertices','viewed','viewing','wants','warden','wecannot','whenever','where','whereas','which','whose','within','words','worked','would','write','xifor','yield','yourself');
	static $first = TRUE;
	if ($first) {
		srand(time());
		$first = FALSE;
	}
	$pass = $words[rand()%count($words)] . "_" . $words[rand()%count($words)];
	
	
	$chars = array("a", "e", "i", "l", "o");
	for ($k=0;$k<2;$k++) {
		for ($i=0;$i<strlen($pass);$i++) {
			if (rand()%7 == 1) {
				$pass[$i] = str_replace($chars, array("@", "3", "!", "1", "0"), $pass[$i]);
			}
		}
	}
	for ($k=0;$k<2;) {
		for ($i=0;$i<strlen($pass);$i++) {
			if (rand()%9 == 2) {
				$pass[$i] = strtoupper($pass[$i]);
				$k++;
			}
		}
	}
	return $pass;
}

/* End of file passowrd_helper.php */
/* Location: ./application/helpers/passowrd_helper.php */
