<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Destiny;
use Overtrue\ChineseCalendar\Calendar;
use Helper;
Use App\Models\Ziwei;
Use App\Models\Star;
Use App\Models\Changerecord;
use com\nlf\calendar\Solar;
use com\nlf\calendar\Lunar;
use com\nlf\calendar\util\LunarUtil;

class DestinyController extends Controller
{
    public function create()
    {
        return view('destiny.index', ['destiny' => new Destiny()]);
    }

    public function show(Destiny $destiny)
    {
        $life_branch = Helper::lifeBranch($destiny['lunar_month'], $destiny['hour_branch']);
        $body_branch = Helper::bodyBranch($destiny['lunar_month'], $destiny['hour_branch']);
        $life = DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',$life_branch)->first();
        $fiveElement = Helper::fiveElement($life->stem,$life->branch);
        $ziwei_id = DB::table('ziweis')->where('destiny_id',$destiny['id'])->first()->id;
        $destinyNo = Helper::convertBranchtoNo(DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('palace','命宮')->first()->branch);
        if (!isset(DB::table('stars')->where('ziwei_id', $ziwei_id)->first()->id)){
            if (($destiny['gender']=="m" and Helper::convertStemtoNo($destiny['year_stem'])%2==1)or($destiny['gender']=="f" && Helper::convertStemtoNo($destiny['year_stem'])%2==0)) {
                for ($i=1; $i<=12; $i++) {
                    Ziwei::where('branch', Helper::convertNotoBranch($destinyNo-1+$i>12?$destinyNo-1+$i-12:$destinyNo-1+$i))->where('destiny_id', $destiny['id'])->update(['begin_age'=> ($i-1)*10+$fiveElement, 'end_age'=> ($i*10)+$fiveElement-1]);
                }
            } else {
                for ($i=1; $i<=12; $i++) {
                    Ziwei::where('branch', Helper::convertNotoBranch($destinyNo+1-$i<=0?$destinyNo+1-$i+12:$destinyNo+1-$i))->where('destiny_id', $destiny['id'])->update(['begin_age'=> ($i-1)*10+$fiveElement, 'end_age'=> ($i*10)+$fiveElement-1]);
                }
            }
            
            if ($destiny['lunar_day'] % $fiveElement == 0) {
                $ziweiStar = intdiv($destiny['lunar_day'],$fiveElement)>12?intdiv($destiny['lunar_day'],$fiveElement)-12:intdiv($destiny['lunar_day'],$fiveElement);
            }
            else {
                $y = intdiv($destiny['lunar_day'], $fiveElement)+1;
                $x = $y*$fiveElement - $destiny['lunar_day'];
                if ($y-$x==0){
                    $ziweiStar = 12;
                }elseif ($x%2==0){
                    $ziweiStar = $y+$x>12?$y+$x-12:$y+$x;
                }elseif ($x>$y){
                    $ziweiStar = 12+($y-$x);
                }else {
                    $ziweiStar = $y-$x>12?$y-$x-12:$y-$x;  
                }
            }
            $tianfuStar = 0;
            switch ($ziweiStar){
                case 1:
                    $tianfuStar = 1;
                    break;
                case 2:
                    $tianfuStar = 12;
                    break;
                default:
                    $tianfuStar = 14-$ziweiStar;
            }
            $tianjiStar = $ziweiStar-1<=0 ?$ziweiStar+11 : $ziweiStar-1;
            $sunStar = $tianjiStar-2<=0 ? $tianjiStar+10 : $tianjiStar-2;
            $financeStar = $sunStar-1<=0 ? $sunStar+11 : $sunStar-1;
            $luckyStar = $financeStar-1<=0 ? $financeStar+11 : $financeStar-1;
            $wickedStar = $luckyStar-3<=0 ? $luckyStar+9 : $luckyStar-3;
            $moonStar = $tianfuStar+1>12 ? $tianfuStar-11 : $tianfuStar+1;
            $wolfStar = $moonStar+1>12 ? $moonStar-11 : $moonStar+1;
            $doorStar = $wolfStar+1>12 ? $wolfStar-11: $wolfStar+1;
            $ministerStar = $doorStar+1>12 ? $doorStar-11: $doorStar+1;
            $fatherStar = $ministerStar+1>12 ? $ministerStar-11: $ministerStar+1;
            $sevenStar = $fatherStar+1>12 ? $fatherStar-11: $fatherStar+1;
            $armyStar = $sevenStar+4>12 ? $sevenStar-8:$sevenStar+4;
            $leftDeputyStar = $destiny['lunar_month']+2>12 ? $destiny['lunar_month']-10:$destiny['lunar_month']+2;
            $rightDeputyStar = 10-$destiny['lunar_month']<=0 ? 10-$destiny['lunar_month']+12:10-$destiny['lunar_month'];
            $punishStar = $destiny['lunar_month']+7>12 ? $destiny['lunar_month']-5:$destiny['lunar_month']+7;
            $romanceStar = $destiny['lunar_month']+11>12 ? $destiny['lunar_month']-1:$destiny['lunar_month']+11;
            $hourBranchNo = Helper::convertBranchNoToNo(Helper::convertBranchToNo($destiny['hour_branch']));
            $wenquStar = $hourBranchNo+2>12 ? $hourBranchNo-10:$hourBranchNo+2;
            $wenchangStar = 9-($hourBranchNo-1)<=0 ? 10-$hourBranchNo+12:10-$hourBranchNo;
            $calamityStar = $hourBranchNo+9>12 ? $hourBranchNo-3:$hourBranchNo+9;
            $misfortuneStar = 10-($hourBranchNo-1)<=0 ? 11-$hourBranchNo+12:11-$hourBranchNo;
            $assistStar = $hourBranchNo+4>12 ? $hourBranchNo-8:$hourBranchNo+4;
            $assignStar = 2-$hourBranchNo<0 ? 2-$hourBranchNo+12 : 2-$hourBranchNo;
            $loveStar = 13-Helper::convertBranchToNo($destiny['year_branch']);
            $likeStar = $loveStar + 6>12?$loveStar-6:$loveStar+6;
            $marsStar = 0;
            $bellStar = 0;
            $tianwuStar = 0;
            switch ($destiny['lunar_month']) {
                case 9:
                case 5:
                case 1:
                    $tianwuStar = 4;
                    break;
                case 11:
                case 7:
                case 3:
                    $tianwuStar = 1;
                break;
                case 2:
                case 6:
                case 10:
                    $tianwuStar = 7;
                    break;
                case 4:
                case 8:
                case 12:
                    $tianwuStar = 10;
                    break;
            }
            switch ($destiny['year_branch']) {
                case "寅":
                case "午":
                case "戌":
                    $marsStar = 11+$hourBranchNo>12 ? $hourBranchNo-1 : $hourBranchNo+11;
                    $bellStar = $hourBranchNo+1>12 ? $hourBranchNo-11:$hourBranchNo+1;
                    break;
                case "申":
                case "子":
                case "辰":
                    $marsStar = $hourBranchNo;
                    $bellStar = $hourBranchNo+8>12 ? $hourBranchNo-4:$hourBranchNo+8;
                break;
                case "巳":
                case "酉":
                case "丑":
                    $marsStar = $hourBranchNo+1>12 ? $hourBranchNo-11:$hourBranchNo+1;
                    $bellStar = $hourBranchNo+8>12 ? $hourBranchNo-4:$hourBranchNo+8;
                    break;
                case "亥":
                case "卯":
                case "未":
                    $marsStar = $hourBranchNo+7>12 ? $hourBranchNo-5 : $hourBranchNo+7;
                    $bellStar = $hourBranchNo+8>12 ? $hourBranchNo-4 : $hourBranchNo+8;
                    break;
            }
            $savingStar=0;
            switch ($destiny['year_stem']) {
                case "甲":
                    $savingStar = 1;
                    $spinningStar = 12;
                    $goatStar = 2;
                    $angel1Star = 6;
                    $angel2Star = 12;
                    break;
                case "乙":
                    $savingStar = 2;
                    $spinningStar = 1;
                    $goatStar = 3;
                    $angel1Star = 7;
                    $angel2Star = 11;
                    break;
                case "丙":
                    $savingStar = 4;
                    $spinningStar = 3;
                    $goatStar = 5;
                    $angel1Star = 8;
                    $angel2Star = 10;
                break;
                case "丁":
                    $savingStar = 5;
                    $spinningStar = 4;
                    $goatStar = 6;
                    $angel1Star = 10;
                    $angel2Star = 8;
                    break;
                case "戊":
                    $savingStar = 4;
                    $spinningStar = 3;
                    $goatStar = 5;
                    $angel1Star = 12;
                    $angel2Star = 6;
                    break;
                case "己":
                    $savingStar = 5;
                    $spinningStar = 4;
                    $goatStar = 6;
                    $angel1Star = 11;
                    $angel2Star = 7;
                    break;
                case "庚":
                    $savingStar = 7;
                    $spinningStar = 6;
                    $goatStar = 8;
                    $angel1Star = 12;
                    $angel2Star = 6;
                    break;
                case "辛":
                    $savingStar = 8;
                    $spinningStar = 7;
                    $goatStar = 9;
                    $angel1Star = 1;
                    $angel2Star = 5;
                    break;
                case "壬":
                    $savingStar = 10;
                    $spinningStar = 9;
                    $goatStar = 11;
                    $angel1Star = 2;
                    $angel2Star = 4;
                    break;
                case "癸":
                    $savingStar = 11;
                    $spinningStar = 10;
                    $goatStar = 12;
                    $angel1Star = 4;
                    $angel2Star = 2;
                break;
            }
            switch ($destiny['year_branch']) {
                case "寅":
                    $horseStar = 7;
                    $alone1Star = 4;
                    $alone2Star = 12;
                    break;
                case "午":
                    $horseStar = 7;
                    $alone1Star = 7;
                    $alone2Star = 3;
                    break;
                case "戌":
                    $horseStar = 7;
                    $alone1Star = 10;
                    $alone2Star = 6;
                    break;
                case "申":
                    $horseStar = 1;
                    $alone1Star = 10;
                    $alone2Star = 6;
                    break;
                case "子":
                    $horseStar = 1;
                    $alone1Star = 1;
                    $alone2Star = 9;
                    break;
                case "辰":
                    $horseStar = 1;
                    $alone1Star = 4;
                    $alone2Star = 12;
                    break;
                case "巳":
                    $horseStar = 10;
                    $alone1Star = 7;
                    $alone2Star = 3;
                    break;
                case "酉":
                    $horseStar = 10;
                    $alone1Star = 10;
                    $alone2Star = 6;
                    break;
                case "丑":
                    $horseStar = 10;
                    $alone1Star = 1;
                    $alone2Star = 9;
                    break;
                case "亥":
                    $horseStar = 4;
                    $alone1Star = 1;
                    $alone2Star = 9;
                    break;
                case "卯":
                    $horseStar = 4;
                    $alone1Star = 4;
                    $alone2Star = 12;
                    break;
                case "未":
                    $horseStar = 4;
                    $alone1Star = 7;
                    $alone2Star = 3;
                    break;
            }
            Star::create([
                'name' => "紫微", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($ziweiStar))->first()->id,
                'destiny_id'=> $destiny->id,
            ]);
            Star::create([
                'name' => "天府", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($tianfuStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "天機", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($tianjiStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "太陽", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($sunStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "武曲", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($financeStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "天同", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($luckyStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "廉貞", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($wickedStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "太陰", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($moonStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "貪狼", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($wolfStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "巨門", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($doorStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "天相", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($ministerStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "天梁", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($fatherStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "七殺", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($sevenStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "破軍", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($armyStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "左輔", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($leftDeputyStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "右弼", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($rightDeputyStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "天刑", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($punishStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "天姚", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($romanceStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "文曲", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($wenquStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "文昌", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($wenchangStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "地劫", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($calamityStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "地空", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($misfortuneStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "台輔", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($assistStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "封誥", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($assignStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "火星", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($marsStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "鈴星", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($bellStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "祿存", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($savingStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "陀羅", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($spinningStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "擎羊", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($goatStar))->first()->id,
                'destiny_id'=> $destiny->id,
                ]);
            Star::create([
                'name' => "天魁", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($angel1Star))->first()->id,
                'destiny_id'=> $destiny->id,
            ]);
            Star::create([
                'name' => "天鉞", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($angel2Star))->first()->id,
                'destiny_id'=> $destiny->id,
            ]);
            Star::create([
                'name' => "天馬", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($horseStar))->first()->id,
                'destiny_id'=> $destiny->id,
            ]);
            Star::create([
                'name' => "孤辰", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($alone1Star))->first()->id,
                'destiny_id'=> $destiny->id,
            ]);
            Star::create([
                'name' => "寡宿", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($alone2Star))->first()->id,
                'destiny_id'=> $destiny->id,
            ]);
            Star::create([
                'name' => "天巫", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($tianwuStar))->first()->id,
                'destiny_id'=> $destiny->id,
            ]);
            Star::create([
                'name' => "紅鸞", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($loveStar))->first()->id,
                'destiny_id'=> $destiny->id,
            ]);
            Star::create([
                'name' => "天喜", 
                'ziwei_id'=> DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('branch',Helper::convertNoToBranch($likeStar))->first()->id,
                'destiny_id'=> $destiny->id,
            ]);
            switch ($destiny['year_stem']) {
                case "甲":
                    $four_change1 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '廉貞')->update(['four_change' => '化祿']);
                    $four_change2 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '破軍')->update(['four_change' => '化權']);
                    $four_change3 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '武曲')->update(['four_change' => '化科']);
                    $four_change4 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '太陽')->update(['four_change' => '化忌']);
                    break;
                case "乙":
                    $four_change1 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天機')->update(['four_change' => '化祿']);
                    $four_change2 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天梁')->update(['four_change' => '化權']);
                    $four_change3 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '紫微')->update(['four_change' => '化科']);
                    $four_change4 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '太陰')->update(['four_change' => '化忌']);
                    break;
                case "丙":
                    $four_change1 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天同')->update(['four_change' => '化祿']);
                    $four_change2 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天機')->update(['four_change' => '化權']);
                    $four_change3 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '文昌')->update(['four_change' => '化科']);
                    $four_change4 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '廉貞')->update(['four_change' => '化忌']);
                    break;
                case "丁":
                    $four_change1 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '太陰')->update(['four_change' => '化祿']);
                    $four_change2 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天同')->update(['four_change' => '化權']);
                    $four_change3 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天機')->update(['four_change' => '化科']);
                    $four_change4 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '巨門')->update(['four_change' => '化忌']);
                    break;
                case "戊":
                    $four_change1 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '貪狼')->update(['four_change' => '化祿']);
                    $four_change2 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '太陰')->update(['four_change' => '化權']);
                    $four_change3 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '右弼')->update(['four_change' => '化科']);
                    $four_change4 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天機')->update(['four_change' => '化忌']);
                    break;
                case "己":
                    $four_change1 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '武曲')->update(['four_change' => '化祿']);
                    $four_change2 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '貪狼')->update(['four_change' => '化權']);
                    $four_change3 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天梁')->update(['four_change' => '化科']);
                    $four_change4 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '文曲')->update(['four_change' => '化忌']);
                    break;
                case "庚":
                    $four_change1 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '太陽')->update(['four_change' => '化祿']);
                    $four_change2 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '武曲')->update(['four_change' => '化權']);
                    $four_change3 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天府')->update(['four_change' => '化科']);
                    $four_change4 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天同')->update(['four_change' => '化忌']);
                    break;
                case "辛":
                    $four_change1 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '巨門')->update(['four_change' => '化祿']);
                    $four_change2 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '太陽')->update(['four_change' => '化權']);
                    $four_change3 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '文曲')->update(['four_change' => '化科']);
                    $four_change4 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '文昌')->update(['four_change' => '化忌']);
                    break;
                case "壬":
                    $four_change1 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '天梁')->update(['four_change' => '化祿']);
                    $four_change2 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '紫微')->update(['four_change' => '化權']);
                    $four_change3 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '左輔')->update(['four_change' => '化科']);
                    $four_change4 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '武曲')->update(['four_change' => '化忌']);
                    break;
                case "癸":
                    $four_change1 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '破軍')->update(['four_change' => '化祿']);
                    $four_change2 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '巨門')->update(['four_change' => '化權']);
                    $four_change3 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '太陰')->update(['four_change' => '化科']);
                    $four_change4 = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name', '貪狼')->update(['four_change' => '化忌']);
                    break;
            }
        };
        if (!isset(DB::table('changerecords')->where('destiny_id', $destiny['id'])->first()->id)){
            $palaces = array("命宮","父母宮","福德宮","田宅宮","事業宮","交友宮","遷移宮","疾厄宮","財帛宮","子女宮","夫妻宮","兄弟宮");
            for ($i=0; $i<count($palaces); $i++) {
                $self[$i] = Helper::change($destiny, $palaces[$i]);
                for ($j=0; $j<4; $j++){
                    Changerecord::create([
                        'self_palace' => $palaces[$i],
                        'change_palace'=> $self[$i][$j]['palace'],
                        'four_change'=> $self[$i][$j]['four_change'],
                        'star_name'=> $self[$i][$j]['star_name'],
                        'destiny_id'=> $destiny->id,
                    ]);
                }   
            }
        }
        $ziweis = $destiny->ziwei()->where('destiny_id', $destiny['id'])->with('stars')->orderBy('begin_age', 'asc')->get();
        $ziwei_id = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name','紫微')->first()->ziwei_id;
        $ziwei_branch = DB::table('ziweis')->where('destiny_id', $destiny['id'])->where('id',$ziwei_id)->first()->branch;
        $analysis = DB::table('analyses')->where('ziwei_branch',$ziwei_branch)->where('life_branch', $life_branch)->first();
        $spinningId = DB::table('stars')->where('destiny_id', $destiny['id'])->where('name','陀羅')->first()->ziwei_id;
        $spinningPalace = Ziwei::find($spinningId)->palace;
        $spinning = DB::table('singlestars')->where('star','陀羅')->where('palace',$spinningPalace)->first();  
        $lackId = DB::table('stars')->where('destiny_id', $destiny['id'])->where('four_change','化忌')->first()->ziwei_id;
        $lackPalace = Ziwei::find($lackId)->palace;
        $lack = DB::table('singlestars')->where('star','化忌')->where('palace',$lackPalace)->first();
        $current_decade = Helper::current_decade($destiny);
        $current_year = Helper::lunar_year(date('Y'));
        $fourChange = Helper::search4change($current_year['stem']);
        $money_results = array_merge(Helper::changeTo($destiny, "財帛宮","化忌"), Helper::changeFrom($destiny, "財帛宮","化忌"));
        $love_results=array_merge(Helper::changeTo($destiny, "夫妻宮","化忌"),Helper::changeFrom($destiny, "夫妻宮","化忌"));
        $career_results = array_merge(Helper::changeTo($destiny, "事業宮","化忌"), Helper::changeFrom($destiny, "事業宮","化忌"));
        return view('destiny.show', compact('money_results', 'career_results', 'love_results','fourChange', 'destiny','life_branch', 'body_branch', 'ziweis', 'analysis','spinning','lack'));
    }

    public function store(Request $request)
    {
        $data = DB::table('destinies')->where('gender', $request->gender)
                ->where('born_year', $request->born_year)
                ->where('born_month', $request->born_month)
                ->where('born_day', $request->born_day)
                ->where('born_hour', $request->born_hour)->distinct()->get();
        if (isset($data[0])) {
            $destiny = Destiny::Find($data[0]->id);
        } else{
            $solar = Solar::fromYmd($request->born_year, $request->born_month, $request->born_day, $request->born_hour, 15, 0);
            $lunar = $solar->getLunar();
            $destiny = Destiny::create([
                'gender' => $request->gender,
                'born_year'=> $request->born_year,
                'born_month'=> $request->born_month,
                'born_day'=> $request->born_day,
                'born_hour'=> $request->born_hour,
                'year_stem' => $lunar->getYearGan(),
                'year_branch' => $lunar->getYearZhi(),
                'month_stem' => $lunar->getMonthGan(),
                'month_branch' => $lunar->getMonthZhi(),
                'day_stem' => $lunar->getDayGan(),
                'day_branch' => $lunar->getDayZhi(),
                'hour_stem' => $lunar->getTimeGan(),
                'hour_branch' => $lunar->getTimeZhi(),
                'lunar_year'=> $lunar->getYear(),
                'lunar_month'=> $lunar->getMonth(),
                'lunar_day'=> $lunar->getDay(),
                'lunar_hour'=> $request->born_hour,
                'lunar_year_chi'=> $lunar->getYearInChinese(),
                'lunar_month_chi'=> $lunar->getMonthInChinese(),
                'lunar_day_chi'=> $lunar->getDayInChinese(),
                'lunar_hour_chi'=> $lunar->getTimeZhi(),
                'animal'=> $lunar->getYearShengXiao(),
                'week_name'=> "星期".$solar->getWeek(),
            ]);
        }
        
        session()->flash('success', '歡迎，您將在這裡開啟一段新的旅程~');
        return redirect()->route('destiny.show', [$destiny]);
    }
}