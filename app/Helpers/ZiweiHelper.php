<?php
namespace App\Helpers;

use App\Models\Destiny;
use Overtrue\ChineseCalendar\Calendar;
use Helper;
use Illuminate\Support\Facades\DB;

class ZiweiHelper
{
    public static function lifeBranch($month_branch, $hour_branch)
      {
        $result = 0;
        switch ($hour_branch) {
            case "子":
                $result = $month_branch;
                break;
            case "丑":
                $result = $month_branch-1;
                break;
            case "寅":
                $result = $month_branch-2;
                break;
            case "卯":
                $result = $month_branch-3;
                break;
            case "辰":
                $result = $month_branch-4;
                break;
            case "巳":
                $result = $month_branch-5;
                break;
            case "午":
                $result = $month_branch-6;
                break;
            case "未":
                $result = $month_branch-7;
                break;
            case "申":
                $result = $month_branch-8;
                break;
            case "酉":
                $result = $month_branch-9;
                break;
            case "戌":
                $result = $month_branch-10;
                break;
            case "亥":
                $result = $month_branch-11;
                break;
        }
        if ($result <=0) {
            $result = $result + 12;
        }
        $life_branch = Helper::convertNoToBranch($result);
        return $life_branch;
    }
    public static function bodyBranch($month_branch, $hour_branch)
    {
        $result = 0;
        switch ($hour_branch) {
            case "子":
                $result = $month_branch;
                break;
            case "丑":
                $result = $month_branch+1;
                break;
            case "寅":
                $result = $month_branch+2;
                break;
            case "卯":
                $result = $month_branch+3;
                break;
            case "辰":
                $result = $month_branch+4;
                break;
            case "巳":
                $result = $month_branch+5;
                break;
            case "午":
                $result = $month_branch+6;
                break;
            case "未":
                $result = $month_branch+7;
                break;
            case "申":
                $result = $month_branch+8;
                break;
            case "酉":
                $result = $month_branch+9;
                break;
            case "戌":
                $result = $month_branch+10;
                break;
            case "亥":
                $result = $month_branch+11;
                break;
        }
        if ($result >12) {
            $result = $result - 12;
        }
        $body_branch = Helper::convertNoToBranch($result);
        return $body_branch;
    }
    public static function convertBranchToNo($body_branch){
        $result = 0;
        switch ($body_branch) {
            case "寅":
                $result = 1;
                break;
            case "卯":
                $result = 2;
                break;
            case "辰":
                $result = 3;
                break;
            case "巳":
                $result = 4;
                break;
            case "午":
                $result = 5;
                break;
            case "未":
                $result = 6;
                break;
            case "申":
                $result = 7;
                break;
            case "酉":
                $result = 8;
                break;
            case "戌":
                $result = 9;
                break;
            case "亥":
                $result = 10;
                break;
            case "子":
                $result = 11;
                break;
            case "丑":
                $result = 12;
                break;
        } 
        return $result;
    }
    public static function convertBranchNoToNo($result){
        $result = ($result+2>=12) ? $result-10 : $result+2;
        return $result;
    }

    public static function convertNoToBranch($result){
        $body_branch = "";
        switch ($result) {
            case 1:
                $body_branch = "寅";
                break;
            case 2:
                $body_branch = "卯";
                break;
            case 3:
                $body_branch = "辰";
                break;
            case 4:
                $body_branch = "巳";
                break;
            case 5:
                $body_branch = "午";
                break;
            case 6:
                $body_branch = "未";
                break;
            case 7:
                $body_branch = "申";
                break;
            case 8:
                $body_branch = "酉";
                break;
            case 9:
                $body_branch = "戌";
                break;
            case 10:
                $body_branch = "亥";
                break;
            case 11:
                $body_branch = "子";
                break;
            case 12:
                $body_branch = "丑";
                break;
        } 
        return $body_branch;
    }
    public static function findFirstStem($year_stem)
    {
        $result=Helper::convertNoToStem((1+2*Helper::convertStemToNo($year_stem)) % 10);
        return $result;
    }
    public static function findOtherStem($branch, $first_year_stem)
    {
        $result=Helper::convertNoToStem(Helper::convertStemToNo($first_year_stem)+(Helper::convertBranchToNo($branch)-1));
        return $result;
    }
    public static function convertNoToStem($stemNumber)
    {
        $year_stem = "";
        if ($stemNumber > 10) {
            $stemNumber = $stemNumber - 10;
        }
        switch ($stemNumber) {
            case 1:
                $year_stem = "甲";
                break;
            case 2:
                $year_stem = "乙";
                break;
            case 3:
                $year_stem = "丙";
                break;
            case 4:
                $year_stem = "丁";
                break;
            case 5:
                $year_stem = "戊";
                break;
            case 6:
                $year_stem = "己";
                break;
            case 7:
                $year_stem = "庚";
                break;
            case 8:
                $year_stem = "辛";
                break;
            case 9:
                $year_stem = "壬";
                break;
            case 10:
                $year_stem = "癸";
                break;
        }   
        return $year_stem;
    }

    public static function convertStemToNo($year_stem)
    {
        $stemNumber =0;
        switch ($year_stem) {
            case "甲":
                $stemNumber = 1;
                break;
            case "乙":
                $stemNumber = 2;
                break;
            case "丙":
                $stemNumber = 3;
                break;
            case "丁":
                $stemNumber = 4;
                break;
            case "戊":
                $stemNumber = 5;
                break;
            case "己":
                $stemNumber = 6;
                break;
            case "庚":
                $stemNumber = 7;
                break;
            case "辛":
                $stemNumber = 8;
                break;
            case "壬":
                $stemNumber = 9;
                break;
            case "癸":
                $stemNumber = 10;
                break;
        }   
        return $stemNumber;
    }
    public static function palace($lifeBranch, $currentBranch)
    {
        $palace="";
        if (Helper::convertBranchToNo($currentBranch)-Helper::convertBranchToNo($lifeBranch)>=0){
            $result = Helper::convertBranchToNo($currentBranch)-Helper::convertBranchToNo($lifeBranch)+1;
        } else {
            $result = Helper::convertBranchToNo($currentBranch)-Helper::convertBranchToNo($lifeBranch)+13;
        }
        switch ($result) {
            case 1:
                $palace = "命宮";
                break;
            case 2:
                $palace = "父母宮";
                break;
            case 3:
                $palace = "福德宮";
                break;
            case 4:
                $palace = "田宅宮";
                break;
            case 5:
                $palace = "事業宮";
                break;
            case 6:
                $palace = "交友宮";
                break;
            case 7:
                $palace = "遷移宮";
                break;
            case 8:
                $palace = "疾厄宮";
                break;
            case 9:
                $palace = "財帛宮";
                break;
            case 10:
                $palace = "子女宮";
                break;
            case 11:
                $palace = "夫妻宮";
                break;
            case 12:
                $palace = "兄弟宮";
                break;
        }
        return $palace;
    }
    public static function fiveElement($stem, $branch)
    {
        $fiveElement = 0;
        $result = $stem.$branch;
        switch ($result) {
            case "丙子":
            case "丁丑":
            case "甲申":
            case "乙酉":
            case "壬辰":
            case "癸巳":
            case "戊戌":
            case "己亥":
            case "丙午":
            case "丁未":
            case "甲寅":
            case "乙卯":
                $fiveElement = 2;
                break;
            case "甲子":
            case "乙丑":
            case "壬申":
            case "癸酉":
            case "庚辰":
            case "辛巳":
            case "壬寅":
            case "癸卯":
            case "庚戌":
            case "辛亥":
            case "甲午":
            case "乙未":
                $fiveElement = 4;
                break;
            case "戊寅":
            case "己卯":
            case "丙戌":
            case "丁亥":
            case "庚子":
            case "辛丑":
            case "戊申":
            case "己酉":
            case "丙辰":
            case "丁巳":
            case "庚午":
            case "辛未":
                $fiveElement = 5;
                break;
            case "戊辰":
            case "己巳":
            case "壬午":
            case "癸未":
            case "庚寅":
            case "辛卯":
            case "戊戌":
            case "己亥":
            case "壬子":
            case "癸丑":
            case "庚申":
            case "辛酉":
                $fiveElement = 3;
                break;
            case "丙寅":
            case "丁卯":
            case "甲戌":
            case "乙亥":
            case "戊子":
            case "己丑":
            case "丙申":
            case "丁酉":
            case "甲辰":
            case "乙巳":
            case "戊午":
            case "己未":
                $fiveElement = 6;
                break;
        }
        return($fiveElement);
    }
    public static function search4change($stem){
        $fourChange[0]='';
        $fourChange[1]='';
        $fourChange[2]='';
        $fourChange[3]='';
        /* 0,1,2,3: 祿權科忌*/
        switch ($stem) {
            case "甲":
                $fourChange[0] = '廉貞';
                $fourChange[1] = '破軍';
                $fourChange[2] = '武曲';
                $fourChange[3] = '太陽';
                break;
            case "乙":
                $fourChange[0] = '天機';
                $fourChange[1] = '天梁';
                $fourChange[2] = '紫微';
                $fourChange[3] = '太陰';
                break;
            case "丙":
                $fourChange[0] = '天同';
                $fourChange[1] = '天機';
                $fourChange[2] = '文昌';
                $fourChange[3] = '廉貞';
                break;
            case "丁":
                $fourChange[0] = '太陰';
                $fourChange[1] = '天同';
                $fourChange[2] = '天機';
                $fourChange[3] = '巨門';
                break;
            case "戊":
                $fourChange[0] = '貪狼';
                $fourChange[1] = '太陰';
                $fourChange[2] = '右弼';
                $fourChange[3] = '天機';
                break;
            case "己":
                $fourChange[0] = '武曲';
                $fourChange[1] = '貪狼';
                $fourChange[2] = '天梁';
                $fourChange[3] = '文曲';
                break;
            case "庚":
                $fourChange[0] = '太陽';
                $fourChange[1] = '武曲';
                $fourChange[2] = '天府';
                $fourChange[3] = '天同';
                break;
            case "辛":
                $fourChange[0] = '巨門';
                $fourChange[1] = '太陽';
                $fourChange[2] = '文曲';
                $fourChange[3] = '文昌';
                break;
            case "壬":
                $fourChange[0] = '天梁';
                $fourChange[1] = '紫微';
                $fourChange[2] = '左輔';
                $fourChange[3] = '武曲';
                break;
            case "癸":
                $fourChange[0] = '破軍';
                $fourChange[1] = '巨門';
                $fourChange[2] = '太陰';
                $fourChange[3] = '貪狼';
                break;
        }
        return ($fourChange);
    }
    public static function lunar_year($year){
        $calendar = new Calendar();
        $date = $calendar->solar($year,3,3);
        $result['stem'] = mb_substr($date['ganzhi_year'], 0, 1, "UTF-8");
        $result['branch'] = mb_substr($date['ganzhi_year'], 1, 1, "UTF-8");
        return($result);
    }
    public static function current_decade(Destiny $destiny){
        $current_year = date("Y");
        $current_age = $current_year-$destiny['born_year'];
        $first_begin_age = DB::table('ziweis')->where('destiny_id', $destiny['id'])->orderBy('begin_age','asc')->first()->begin_age;
        for ($i=0; $i<=11; $i++){
            $current_decade = DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('begin_age',$first_begin_age+(10*$i))->first();
            if ($current_decade->end_age>=$current_age) break;
        }
        return $current_decade;
    }
    public static function find_decade(Destiny $destiny, $current_year){
        $current_age = $current_year-$destiny['born_year']+1;
        $first_begin_age = DB::table('ziweis')->where('destiny_id', $destiny['id'])->orderBy('begin_age','asc')->first()->begin_age;
        for ($i=0; $i<=11; $i++){
            $current_decade = DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('begin_age',$first_begin_age+(10*$i))->first();
            if ($current_decade->end_age>=$current_age) break;
        }
        return $current_decade;
    }
    public static function rewriteZiwei(Destiny $destiny, $new_life_branch){
        $palaces = array("命宮","父母宮","福德宮","田宅宮","事業宮","交友宮","遷移宮","疾厄宮","財帛宮","子女宮","夫妻宮","兄弟宮");
        $result = DB::table('ziweis')->where('destiny_id', $destiny['id'])->get();
        for ($i=0;$i<=11;$i++) {
            if ($result[$i]->branch == $new_life_branch) break;
        }
        $new_no=$i;
        for ($j=0;$j<=11;$j++) {
            $result[$new_no+$j]->palace = $palaces[$j];
            if ($new_no+$j==11) {
                $new_no = -$j-1;
            }
        }
        return $result;
    }
    public static function starPalace(Destiny $destiny, $starname){
        $starId = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', $starname)->first()->ziwei_id;
        $result = DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('id', $starId)->first();
        return $result;
    }
    public static function starDecadePalace(Destiny $destiny, $starname, $decade){
        $starId = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name',$starname)->first()->ziwei_id;
        $new_ziwei= Helper::rewriteZiwei($destiny, $decade->branch);
        $result= $new_ziwei->where('id',$starId)->first();
        return $result;
    }
    public static function starYearPalace(Destiny $destiny, $starname, $year){
        $starId = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name',$starname)->first()->ziwei_id;
        $lunar_year = Helper::lunar_year($year);
        $branch = $lunar_year['branch'];
        $new_ziwei= Helper::rewriteZiwei($destiny, $branch);
        $result= $new_ziwei->where('id',$starId)->first();
        return $result;
    }
    public static function fourChangePalace(Destiny $destiny, $four_change){
        $starId = DB::table('stars')->where('destiny_id', $destiny['id'])->where('four_change', $four_change)->first()->ziwei_id;
        $result = DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('id', $starId)->first();
        return $result;
    }
    public static function fourChangeDecadePalace(Destiny $destiny, $four_change, $decade){
        $four_changes = array('化祿','化權','化科','化忌');
        $stars = Helper::search4change($decade->stem);
        $starname = $stars[array_search($four_change, $four_changes)];
        $starId = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name',$starname)->first()->ziwei_id;
        $new_ziwei= Helper::rewriteZiwei($destiny, $decade->branch);
        $result= $new_ziwei->where('id',$starId)->first();
        return $result;
    }
    public static function fourChangeYearPalace(Destiny $destiny, $four_change, $year){
        $lunar_year = Helper::lunar_year($year);
        $four_changes = array('化祿','化權','化科','化忌');
        $stars = Helper::search4change( $lunar_year['stem']);
        $starname = $stars[array_search($four_change, $four_changes)];
        $starId = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name',$starname)->first()->ziwei_id;
        $new_ziwei= Helper::rewriteZiwei($destiny, $lunar_year['branch']);
        $result= $new_ziwei->where('id',$starId)->first();
        return $result;
    }
    public static function squarePalace($palace){
        switch($palace){
            case "命宮":
                $result=array("命宮","遷移宮","事業宮","財帛宮");
                break;
            case "父母宮":
                $result=array("父母宮","疾厄宮","交友宮","子女宮");
                break;
            case "福德宮":
                $result=array("福德宮","財帛宮","遷移宮","夫妻宮");
                break;
            case "田宅宮":
                $result=array("田宅宮","子女宮","疾厄宮","兄弟宮");
                break;
            case "事業宮":
                $result=array("事業宮","夫妻宮","財帛宮","命宮");
                break;
            case "交友宮":
                $result=array("交友宮","兄弟宮","子女宮","父母宮");
                break;
            case "遷移宮":
                $result=array("遷移宮","命宮","福德宮","夫妻宮");
                break;
            case "疾厄宮":
                $result=array("疾厄宮","父母宮","兄弟宮","田宅宮");
                break;
            case "財帛宮":
                $result=array("財帛宮","福德宮","命宮","事業宮");
                break;
            case "子女宮":
                $result=array("子女宮","田宅宮","父母宮","交友宮");
                break;
            case "夫妻宮":
                $result=array("夫妻宮","事業宮","福德宮","遷移宮");
                break;
            case "兄弟宮":
                $result=array("兄弟宮","交友宮","田宅宮","疾厄宮");
                break;
        }
        return $result;
    }
    public static function squareBranch($branchNo){
        $second = $branchNo+4>12?$branchNo-8:$branchNo+4;
        $third = $second+2>12?$second-10:$second+2;
        $forth = $third+2>12?$third-10:$third+2;
        $result = array($branchNo, $second, $third, $forth);
        return $result;
    }
    public static function badLuckCount(Destiny $destiny, $palace){
        $palaceBranch = Helper::convertBranchToNo(DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('palace',$palace)->first()->branch);
        $badLuckStars = array("火星","鈴星","擎羊","陀羅");
        for ($i=0; $i<4; $i++){
            $badZiweiId[$i] = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name',$badLuckStars[$i])->first()->ziwei_id;
            $badZiweis[$i] = DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('id',$badZiweiId[$i])->first();
        }
        $badZiweis[4] = Helper::fourChangePalace($destiny, "化忌");
        $squareBranchs = Helper::squareBranch($palaceBranch);
        $badCount=0;
        for ($i=0; $i<5; $i++){
            if ($squareBranchs[0] == Helper::convertBranchToNo($badZiweis[$i]->branch)){
                $badCount++;
            }
            if ($squareBranchs[1] == Helper::convertBranchToNo($badZiweis[$i]->branch)){
                $badCount++;
            }
            if ($squareBranchs[2] == Helper::convertBranchToNo($badZiweis[$i]->branch)){
                $badCount++;
            }
            if ($squareBranchs[3] == Helper::convertBranchToNo($badZiweis[$i]->branch)){
                $badCount++;
            }
        }
        return $badCount;
    }
    public static function badLuckDecadeCount(Destiny $destiny, $decade, $palace){
        $decade_ziwei=Helper::rewriteZiwei($destiny, $decade->branch);
        $palace_branch = $decade_ziwei->where('palace', $palace)->first()->branch;
        $original = DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch', $palace_branch)->first();
        $badCount = Helper::badLuckCount($destiny, $original->palace);
        $squareBranchs = Helper::squareBranch(Helper::convertBranchToNo($original->branch));
        $decadeBadStarBranch =  Helper::convertBranchToNo(Helper::fourChangeDecadePalace($destiny, "化忌", $decade)->branch);
        for ($i=0; $i<4; $i++){
            if ($squareBranchs[$i] == $decadeBadStarBranch){
                $badCount++;
            }
        }
        return $badCount;
    }

    public static function badLuckYearCount(Destiny $destiny, $year, $palace){
        $lunar_year = Helper::lunar_year($year);
        $year_branch = $lunar_year['branch'];
        $year_ziwei=Helper::rewriteZiwei($destiny, $year_branch);
        $year_palace_branch = $year_ziwei->where('palace', $palace)->first()->branch;
        $decade = Helper::find_decade($destiny, $year);
        $decade_ziwei=Helper::rewriteZiwei($destiny, $decade->branch);
        $decade_palace = $decade_ziwei->where('branch', $year_palace_branch)->first()->palace;
        $badCount = Helper::badLuckDecadeCount($destiny, $decade, $decade_palace);
        $squareBranchs = Helper::squareBranch(Helper::convertBranchToNo($year_palace_branch));
        $yearBadStarBranch =  Helper::convertBranchToNo(Helper::fourChangeYearPalace($destiny, "化忌", $year)->branch);
        for ($i=0; $i<4; $i++){
            if ($squareBranchs[$i] == $yearBadStarBranch){
                $badCount++;
            }
        }
        return $badCount;
    }
    public static function maxBadLuckYearCount(Destiny $destiny, $year){
        $palaces = array("命宮","父母宮","福德宮","田宅宮","事業宮","交友宮","遷移宮","疾厄宮","財帛宮","子女宮","夫妻宮","兄弟宮");
        $result = [];
        for ($i=0; $i<12; $i++) {
            $badLuckCountArray[$i] = Helper::badLuckYearCount($destiny, $year, $palaces[$i]);
            if ($badLuckCountArray[$i] > 2){
                array_push($result, $palaces[$i]);
            }
        }
        return $result;
    }
    public static function changeFindStem($starName){
        $stem[0]="";
        $stem[1]="";
        $stem[2]="";
        $stem[3]="";
        switch ($starName) {
            case "廉貞":
                $stem[0]="甲";
                $stem[3]="丙";
                break; 
            case "破軍":
                $stem[0]="癸";
                $stem[1]="甲";
                break;
            case "武曲":
                $stem[0]="己";
                $stem[1]="庚";
                $stem[2]="甲";
                $stem[3]="壬";
                break; 
            case "太陽":
                $stem[0]="庚";
                $stem[1]="辛";
                $stem[3]="甲";
                break; 
            case "天機":
                $stem[0]="乙";
                $stem[1]="丙";
                $stem[2]="丁";
                $stem[3]="戊";
                break;
            case "天梁":
                $stem[0]="壬";
                $stem[1]="乙";
                $stem[2]="己";
                break;
            case "紫微":
                $stem[1]="壬";
                $stem[2]="乙";
                break;
            case "太陰":
                $stem[0]="丁";
                $stem[1]="戊";
                $stem[2]="癸";
                $stem[3]="乙";
                break;
            case "天同":
                $stem[0]="丙";
                $stem[1]="丁";
                $stem[3]="庚";
                break;
            case "文昌":
                $stem[3]="辛";
                $stem[2]="丙";
                break;
            case "巨門":
                $stem[0]="辛";
                $stem[1]="癸";
                $stem[3]="丁";
                break;
            case "貪狼":
                $stem[0]="戊";
                $stem[1]="己";
                $stem[3]="癸";
                break;
            case "右弼":
                $stem[2]="戊";
                break;
            case "文曲":
                $stem[2]="辛";
                $stem[3]="己";
                break;
            case "天府":
                $stem[2]="庚";
                break;
            case "左輔":
                $stem[2]="壬";
                break;
        }
        return($stem);
    }
    // 找出原宮四化的星、四化及宮位
    public static function change(Destiny $destiny, $palace){
        $four_changes = ["化祿","化權","化科","化忌"];
        $stem = DB::Table("ziweis")->where("destiny_id", $destiny['id'])->where("palace", $palace)->first()->stem;
        $selfStars = Helper::search4change($stem);
        $self=collect([]);
        for ($i=0; $i<4; $i++) {
            $ziwei_id = DB::Table("stars")->where("destiny_id", $destiny['id'])->where("name", $selfStars[$i])->first()->ziwei_id;
            $self->push(['star_name'=> $selfStars[$i],'four_change'=>$four_changes[$i],'palace'=>DB::Table("ziweis")->where("destiny_id", $destiny['id'])->where("id",$ziwei_id)->first()->palace]);
        }
        return $self;
    }
    // 找出這個宮位被哪一個四化及宮位飛入的評語
    public static function changeTo(Destiny $destiny, $palace, $four_change){
        $results = DB::Table("changerecords")->where("destiny_id", $destiny['id'])->where("change_palace", $palace)->where("four_change", $four_change)->get();
        $final_results=[];
        for ($i=0; $i<count($results); $i++){
            $final_result = DB::table('fourchanges')->where('self_palace',$results[$i]->self_palace)->where('change_palace',$palace)->first();
            if (!empty($final_result->description)){
                $final_results[$i]=$final_result->description;
            } 
        }
        return $final_results;
    }
    public static function changeFrom(Destiny $destiny, $palace, $four_change){
        $results = DB::Table("changerecords")->where("destiny_id", $destiny['id'])->where("self_palace", $palace)->where("four_change", $four_change)->get();
        $final_results=[];
        for ($i=0; $i<count($results); $i++){
            $final_result = DB::table('fourchanges')->where('change_palace',$results[$i]->change_palace)->where('self_palace',$palace)->first();
            if (!empty($final_result->description)){
                $final_results[$i]=$final_result->description;
            } 
        }
        return $final_results;
    }
}