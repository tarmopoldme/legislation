<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1488712753.
 * Generated on 2017-04-14 16:19:13 by tarmo
 */
class PropelMigration_1492175967
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `act` ADD `betweenness_weight` decimal(12,7) unsigned NULL AFTER `confirmity_weight`;

UPDATE act SET betweenness_weight=17.755181161278735 WHERE id=1;    
UPDATE act SET betweenness_weight=7.6868275113715350 WHERE id=2;
UPDATE act SET betweenness_weight=186.70060364048555 WHERE id=3;
UPDATE act SET betweenness_weight=25.187351953276387 WHERE id=4;
UPDATE act SET betweenness_weight=349.61386591902976 WHERE id=5;
UPDATE act SET betweenness_weight=170.35118692434335 WHERE id=6;
UPDATE act SET betweenness_weight=35.306514893330984 WHERE id=7;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=8;
UPDATE act SET betweenness_weight=496.98814650270510 WHERE id=9;
UPDATE act SET betweenness_weight=405.38137716283680 WHERE id=10;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=11;
UPDATE act SET betweenness_weight=1274.8611739521923 WHERE id=12;
UPDATE act SET betweenness_weight=203.14680944059194 WHERE id=13;
UPDATE act SET betweenness_weight=354.12409937446535 WHERE id=14;
UPDATE act SET betweenness_weight=839.86268644899290 WHERE id=15;
UPDATE act SET betweenness_weight=661.02083707857390 WHERE id=16;
UPDATE act SET betweenness_weight=90.686399301527840 WHERE id=17;
UPDATE act SET betweenness_weight=2805.5322852721450 WHERE id=18;
UPDATE act SET betweenness_weight=3464.0429322940990 WHERE id=19;
UPDATE act SET betweenness_weight=100.84460500510814 WHERE id=20;
UPDATE act SET betweenness_weight=10.806552837174140 WHERE id=21;
UPDATE act SET betweenness_weight=3.3605587037088585 WHERE id=22;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=23;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=24;
UPDATE act SET betweenness_weight=487.11828429508150 WHERE id=25;
UPDATE act SET betweenness_weight=13.418473367532272 WHERE id=26;
UPDATE act SET betweenness_weight=4.2447964797964800 WHERE id=27;
UPDATE act SET betweenness_weight=50.284278268197454 WHERE id=28;
UPDATE act SET betweenness_weight=2.7495238095238093 WHERE id=29;
UPDATE act SET betweenness_weight=328.88512306265255 WHERE id=30;
UPDATE act SET betweenness_weight=1.1038536627602924 WHERE id=31;
UPDATE act SET betweenness_weight=2068.5770233112590 WHERE id=32;
UPDATE act SET betweenness_weight=799.20991069966460 WHERE id=33;
UPDATE act SET betweenness_weight=1980.6356941668273 WHERE id=34;
UPDATE act SET betweenness_weight=0.5000000000000000 WHERE id=35;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=36;
UPDATE act SET betweenness_weight=122.62359492370193 WHERE id=37;
UPDATE act SET betweenness_weight=2111.8554027274135 WHERE id=38;
UPDATE act SET betweenness_weight=21.673571049987245 WHERE id=39;
UPDATE act SET betweenness_weight=1903.8685338861055 WHERE id=40;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=41;
UPDATE act SET betweenness_weight=34.262826472786330 WHERE id=42;
UPDATE act SET betweenness_weight=357.00712469326880 WHERE id=43;
UPDATE act SET betweenness_weight=1804.1117982370765 WHERE id=44;
UPDATE act SET betweenness_weight=451.40293758492567 WHERE id=45;
UPDATE act SET betweenness_weight=11.791092439496177 WHERE id=46;
UPDATE act SET betweenness_weight=14.051312242071104 WHERE id=47;
UPDATE act SET betweenness_weight=841.73683647079550 WHERE id=48;
UPDATE act SET betweenness_weight=118.11178500524848 WHERE id=49;
UPDATE act SET betweenness_weight=4.7389610389610390 WHERE id=50;
UPDATE act SET betweenness_weight=463.35126195260176 WHERE id=51;
UPDATE act SET betweenness_weight=38.610730070382340 WHERE id=52;
UPDATE act SET betweenness_weight=27.366654165404622 WHERE id=53;
UPDATE act SET betweenness_weight=302.07777030789725 WHERE id=54;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=55;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=56;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=57;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=58;
UPDATE act SET betweenness_weight=383.63623896263556 WHERE id=59;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=60;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=61;
UPDATE act SET betweenness_weight=32.428404885576490 WHERE id=62;
UPDATE act SET betweenness_weight=275.08117859241530 WHERE id=63;
UPDATE act SET betweenness_weight=35.450125268615075 WHERE id=64;
UPDATE act SET betweenness_weight=0.6984126984126984 WHERE id=65;
UPDATE act SET betweenness_weight=79.986351555323420 WHERE id=66;
UPDATE act SET betweenness_weight=99.012671751809120 WHERE id=67;
UPDATE act SET betweenness_weight=2204.5540377717193 WHERE id=68;
UPDATE act SET betweenness_weight=3401.9214943404580 WHERE id=69;
UPDATE act SET betweenness_weight=5174.6450776456440 WHERE id=70;
UPDATE act SET betweenness_weight=221.02299120474768 WHERE id=71;
UPDATE act SET betweenness_weight=1.9096037267412695 WHERE id=72;
UPDATE act SET betweenness_weight=284.74889014007346 WHERE id=73;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=74;
UPDATE act SET betweenness_weight=6.4356312971955330 WHERE id=75;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=76;
UPDATE act SET betweenness_weight=23.518923106184580 WHERE id=77;
UPDATE act SET betweenness_weight=588.81625103600100 WHERE id=78;
UPDATE act SET betweenness_weight=197.88290002881283 WHERE id=79;
UPDATE act SET betweenness_weight=24.105132502682682 WHERE id=80;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=81;
UPDATE act SET betweenness_weight=889.70749401735450 WHERE id=82;
UPDATE act SET betweenness_weight=591.16056012039110 WHERE id=83;
UPDATE act SET betweenness_weight=734.39248972543090 WHERE id=84;
UPDATE act SET betweenness_weight=75.900563795506070 WHERE id=85;
UPDATE act SET betweenness_weight=408.19507814098380 WHERE id=86;
UPDATE act SET betweenness_weight=1415.5894319892690 WHERE id=87;
UPDATE act SET betweenness_weight=0.7414141414141415 WHERE id=88;
UPDATE act SET betweenness_weight=110.04715826112346 WHERE id=89;
UPDATE act SET betweenness_weight=271.25766239667615 WHERE id=90;
UPDATE act SET betweenness_weight=437.53373469234260 WHERE id=91;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=92;
UPDATE act SET betweenness_weight=67.324018714827180 WHERE id=93;
UPDATE act SET betweenness_weight=550.33871476754550 WHERE id=94;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=95;
UPDATE act SET betweenness_weight=1300.6474871749015 WHERE id=96;
UPDATE act SET betweenness_weight=2558.9207811895394 WHERE id=97;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=98;
UPDATE act SET betweenness_weight=2.4329898203219080 WHERE id=99;
UPDATE act SET betweenness_weight=2124.9594867659010 WHERE id=100;
UPDATE act SET betweenness_weight=93.566756493116670 WHERE id=101;
UPDATE act SET betweenness_weight=3.3312234224242014 WHERE id=102;
UPDATE act SET betweenness_weight=158.18583751726013 WHERE id=103;
UPDATE act SET betweenness_weight=81.625259565040520 WHERE id=104;
UPDATE act SET betweenness_weight=1290.8112608674590 WHERE id=105;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=106;
UPDATE act SET betweenness_weight=559.96188959431220 WHERE id=107;
UPDATE act SET betweenness_weight=4.7725883834821570 WHERE id=108;
UPDATE act SET betweenness_weight=166.47534529400170 WHERE id=109;
UPDATE act SET betweenness_weight=29.249741014243740 WHERE id=110;
UPDATE act SET betweenness_weight=85.675476922297850 WHERE id=111;
UPDATE act SET betweenness_weight=0.8859203317483164 WHERE id=112;
UPDATE act SET betweenness_weight=269.83139724266005 WHERE id=113;
UPDATE act SET betweenness_weight=424.61416967979915 WHERE id=114;
UPDATE act SET betweenness_weight=126.58153043402746 WHERE id=115;
UPDATE act SET betweenness_weight=714.58535473099360 WHERE id=116;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=117;
UPDATE act SET betweenness_weight=114.95894383397650 WHERE id=118;
UPDATE act SET betweenness_weight=94.231256800873940 WHERE id=119;
UPDATE act SET betweenness_weight=116.40238165321485 WHERE id=120;
UPDATE act SET betweenness_weight=398.96342130702453 WHERE id=121;
UPDATE act SET betweenness_weight=387.58760191934624 WHERE id=122;
UPDATE act SET betweenness_weight=9.3363923644945150 WHERE id=123;
UPDATE act SET betweenness_weight=1864.7703071348012 WHERE id=124;
UPDATE act SET betweenness_weight=233.49568674210275 WHERE id=125;
UPDATE act SET betweenness_weight=186.20095914769550 WHERE id=126;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=127;
UPDATE act SET betweenness_weight=13.923323786227492 WHERE id=128;
UPDATE act SET betweenness_weight=414.41082573731404 WHERE id=129;
UPDATE act SET betweenness_weight=59.158741222036150 WHERE id=130;
UPDATE act SET betweenness_weight=446.45214130112896 WHERE id=131;
UPDATE act SET betweenness_weight=137.23956615096827 WHERE id=132;
UPDATE act SET betweenness_weight=83.796649738151860 WHERE id=133;
UPDATE act SET betweenness_weight=35.159958597785790 WHERE id=134;
UPDATE act SET betweenness_weight=13.550625976985565 WHERE id=135;
UPDATE act SET betweenness_weight=939.48464603346840 WHERE id=136;
UPDATE act SET betweenness_weight=558.03295300522730 WHERE id=137;
UPDATE act SET betweenness_weight=91.116504689570150 WHERE id=138;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=139;
UPDATE act SET betweenness_weight=5544.1044820338420 WHERE id=140;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=141;
UPDATE act SET betweenness_weight=46.258306552096535 WHERE id=142;
UPDATE act SET betweenness_weight=93.963122418073740 WHERE id=143;
UPDATE act SET betweenness_weight=279.12666359456983 WHERE id=144;
UPDATE act SET betweenness_weight=182.35300709024747 WHERE id=145;
UPDATE act SET betweenness_weight=1398.9410499527567 WHERE id=146;
UPDATE act SET betweenness_weight=6.1590940921823270 WHERE id=147;
UPDATE act SET betweenness_weight=4017.0533879380228 WHERE id=148;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=149;
UPDATE act SET betweenness_weight=34.920925553044590 WHERE id=150;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=151;
UPDATE act SET betweenness_weight=68.644307054894170 WHERE id=152;
UPDATE act SET betweenness_weight=98.856954233149270 WHERE id=153;
UPDATE act SET betweenness_weight=145.09316590346216 WHERE id=154;
UPDATE act SET betweenness_weight=4.1310647685647690 WHERE id=155;
UPDATE act SET betweenness_weight=409.01134036817757 WHERE id=156;
UPDATE act SET betweenness_weight=30.598660608949537 WHERE id=157;
UPDATE act SET betweenness_weight=126.86762808454289 WHERE id=158;
UPDATE act SET betweenness_weight=38.722580018597950 WHERE id=159;
UPDATE act SET betweenness_weight=182.47254973788960 WHERE id=160;
UPDATE act SET betweenness_weight=375.93527075329877 WHERE id=161;
UPDATE act SET betweenness_weight=144.57686477468772 WHERE id=162;
UPDATE act SET betweenness_weight=1568.6456229984026 WHERE id=163;
UPDATE act SET betweenness_weight=880.20894366198160 WHERE id=164;
UPDATE act SET betweenness_weight=12.673512434361973 WHERE id=165;
UPDATE act SET betweenness_weight=645.41561757133540 WHERE id=166;
UPDATE act SET betweenness_weight=352.59886890131304 WHERE id=167;
UPDATE act SET betweenness_weight=56.683586333575230 WHERE id=168;
UPDATE act SET betweenness_weight=62.577953045232090 WHERE id=169;
UPDATE act SET betweenness_weight=40.228185817417700 WHERE id=170;
UPDATE act SET betweenness_weight=150.49423140373256 WHERE id=171;
UPDATE act SET betweenness_weight=149.53405704519446 WHERE id=172;
UPDATE act SET betweenness_weight=190.31856547978313 WHERE id=173;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=174;
UPDATE act SET betweenness_weight=22.563839309241660 WHERE id=175;
UPDATE act SET betweenness_weight=59.693919871890785 WHERE id=176;
UPDATE act SET betweenness_weight=1470.6797622381362 WHERE id=177;
UPDATE act SET betweenness_weight=0.4797036297036297 WHERE id=178;
UPDATE act SET betweenness_weight=2011.1824274468163 WHERE id=179;
UPDATE act SET betweenness_weight=0.0815322829780661 WHERE id=180;
UPDATE act SET betweenness_weight=14786.797231341397 WHERE id=181;
UPDATE act SET betweenness_weight=1.7466004583651642 WHERE id=182;
UPDATE act SET betweenness_weight=211.38169807735696 WHERE id=183;
UPDATE act SET betweenness_weight=9.8966139517430900 WHERE id=184;
UPDATE act SET betweenness_weight=6367.5991505052580 WHERE id=185;
UPDATE act SET betweenness_weight=155.31522686768625 WHERE id=186;
UPDATE act SET betweenness_weight=558.04682181072670 WHERE id=187;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=188;
UPDATE act SET betweenness_weight=261.31308182302050 WHERE id=189;
UPDATE act SET betweenness_weight=125.68296523367015 WHERE id=190;
UPDATE act SET betweenness_weight=394.26279536014107 WHERE id=191;
UPDATE act SET betweenness_weight=22.464973872554120 WHERE id=192;
UPDATE act SET betweenness_weight=1598.8156689670443 WHERE id=193;
UPDATE act SET betweenness_weight=567.84990426692710 WHERE id=194;
UPDATE act SET betweenness_weight=152.81378732788310 WHERE id=195;
UPDATE act SET betweenness_weight=114.66277127869182 WHERE id=196;
UPDATE act SET betweenness_weight=10.102081259731136 WHERE id=197;
UPDATE act SET betweenness_weight=178.49423254423533 WHERE id=198;
UPDATE act SET betweenness_weight=51.126231841169620 WHERE id=199;
UPDATE act SET betweenness_weight=34.080404225519180 WHERE id=200;
UPDATE act SET betweenness_weight=145.74372945756443 WHERE id=201;
UPDATE act SET betweenness_weight=973.22096770138570 WHERE id=202;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=203;
UPDATE act SET betweenness_weight=36.126249346424000 WHERE id=204;
UPDATE act SET betweenness_weight=37.922014810279240 WHERE id=205;
UPDATE act SET betweenness_weight=163.87102228301990 WHERE id=206;
UPDATE act SET betweenness_weight=43.422910224896086 WHERE id=207;
UPDATE act SET betweenness_weight=98.059077159039090 WHERE id=208;
UPDATE act SET betweenness_weight=1060.6907537926868 WHERE id=209;
UPDATE act SET betweenness_weight=75.475058042516740 WHERE id=210;
UPDATE act SET betweenness_weight=149.77028434163800 WHERE id=211;
UPDATE act SET betweenness_weight=222.47202733613096 WHERE id=212;
UPDATE act SET betweenness_weight=853.67290149813550 WHERE id=213;
UPDATE act SET betweenness_weight=537.47752203957590 WHERE id=214;
UPDATE act SET betweenness_weight=37.467519554061170 WHERE id=215;
UPDATE act SET betweenness_weight=439.48505688669920 WHERE id=216;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=217;
UPDATE act SET betweenness_weight=357.61331318109760 WHERE id=218;
UPDATE act SET betweenness_weight=283.32014581888495 WHERE id=219;
UPDATE act SET betweenness_weight=0.1281660692951015 WHERE id=220;
UPDATE act SET betweenness_weight=37.762635742154360 WHERE id=221;
UPDATE act SET betweenness_weight=28.436465558965892 WHERE id=222;
UPDATE act SET betweenness_weight=82.296129277723250 WHERE id=223;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=224;
UPDATE act SET betweenness_weight=32.882637323124590 WHERE id=225;
UPDATE act SET betweenness_weight=1210.7835908245286 WHERE id=226;
UPDATE act SET betweenness_weight=189.58925648828122 WHERE id=227;
UPDATE act SET betweenness_weight=67.584593082929830 WHERE id=228;
UPDATE act SET betweenness_weight=146.34391513350414 WHERE id=229;
UPDATE act SET betweenness_weight=250.18211191771053 WHERE id=230;
UPDATE act SET betweenness_weight=262.80086408220086 WHERE id=231;
UPDATE act SET betweenness_weight=328.90099982941690 WHERE id=232;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=233;
UPDATE act SET betweenness_weight=39.254718651109210 WHERE id=234;
UPDATE act SET betweenness_weight=1091.9927451164992 WHERE id=235;
UPDATE act SET betweenness_weight=1237.9295604004797 WHERE id=236;
UPDATE act SET betweenness_weight=43.448386171561160 WHERE id=237;
UPDATE act SET betweenness_weight=4.3895600433218510 WHERE id=238;
UPDATE act SET betweenness_weight=98.757979485024490 WHERE id=239;
UPDATE act SET betweenness_weight=234.59011932701083 WHERE id=240;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=241;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=242;
UPDATE act SET betweenness_weight=19.014592400348448 WHERE id=243;
UPDATE act SET betweenness_weight=60.234894986777810 WHERE id=244;
UPDATE act SET betweenness_weight=208.00898859930038 WHERE id=245;
UPDATE act SET betweenness_weight=512.83843581313490 WHERE id=246;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=247;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=248;
UPDATE act SET betweenness_weight=50.197122254188415 WHERE id=249;
UPDATE act SET betweenness_weight=1334.7003727138597 WHERE id=250;
UPDATE act SET betweenness_weight=741.79417822180280 WHERE id=251;
UPDATE act SET betweenness_weight=440.56085742450430 WHERE id=252;
UPDATE act SET betweenness_weight=727.68013215992140 WHERE id=253;
UPDATE act SET betweenness_weight=752.51067054249960 WHERE id=254;
UPDATE act SET betweenness_weight=1171.2237690961751 WHERE id=255;
UPDATE act SET betweenness_weight=0.6781626108940949 WHERE id=256;
UPDATE act SET betweenness_weight=1233.2314584430628 WHERE id=257;
UPDATE act SET betweenness_weight=1072.4676599221834 WHERE id=258;
UPDATE act SET betweenness_weight=214.10929112310570 WHERE id=259;
UPDATE act SET betweenness_weight=293.22625096460064 WHERE id=260;
UPDATE act SET betweenness_weight=469.03429095904033 WHERE id=261;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=262;
UPDATE act SET betweenness_weight=19915.608705652360 WHERE id=263;
UPDATE act SET betweenness_weight=533.26901524907800 WHERE id=264;
UPDATE act SET betweenness_weight=1323.8723619361874 WHERE id=265;
UPDATE act SET betweenness_weight=173.48195716592207 WHERE id=266;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=267;
UPDATE act SET betweenness_weight=3403.6106238864820 WHERE id=268;
UPDATE act SET betweenness_weight=165.39632942477460 WHERE id=269;
UPDATE act SET betweenness_weight=132.62707397619343 WHERE id=270;
UPDATE act SET betweenness_weight=22.595702642255393 WHERE id=271;
UPDATE act SET betweenness_weight=29.275156711355386 WHERE id=272;
UPDATE act SET betweenness_weight=1880.4794463541155 WHERE id=273;
UPDATE act SET betweenness_weight=478.12942046821640 WHERE id=274;
UPDATE act SET betweenness_weight=22.872778117171393 WHERE id=275;
UPDATE act SET betweenness_weight=19.237059742499948 WHERE id=276;
UPDATE act SET betweenness_weight=8.8746238902165850 WHERE id=277;
UPDATE act SET betweenness_weight=174.65830202896467 WHERE id=278;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=279;
UPDATE act SET betweenness_weight=58.882373572096680 WHERE id=280;
UPDATE act SET betweenness_weight=165.62340384798364 WHERE id=281;
UPDATE act SET betweenness_weight=40.378695514673190 WHERE id=282;
UPDATE act SET betweenness_weight=2133.5731637583720 WHERE id=283;
UPDATE act SET betweenness_weight=117.39646612501580 WHERE id=284;
UPDATE act SET betweenness_weight=104.75200280744100 WHERE id=285;
UPDATE act SET betweenness_weight=285.19357072681760 WHERE id=286;
UPDATE act SET betweenness_weight=31.510684709844316 WHERE id=287;
UPDATE act SET betweenness_weight=5.7359355497513390 WHERE id=288;
UPDATE act SET betweenness_weight=2.6775281647065796 WHERE id=289;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=290;
UPDATE act SET betweenness_weight=2.7241480741480744 WHERE id=291;
UPDATE act SET betweenness_weight=123.97582573587242 WHERE id=292;
UPDATE act SET betweenness_weight=8.3420957988880800 WHERE id=293;
UPDATE act SET betweenness_weight=109.85440655158257 WHERE id=294;
UPDATE act SET betweenness_weight=96.268913750662820 WHERE id=295;
UPDATE act SET betweenness_weight=180.94138839507127 WHERE id=296;
UPDATE act SET betweenness_weight=89.620821946194080 WHERE id=297;
UPDATE act SET betweenness_weight=279.27212836335224 WHERE id=298;
UPDATE act SET betweenness_weight=47.864754323074880 WHERE id=299;
UPDATE act SET betweenness_weight=881.88231998404250 WHERE id=300;
UPDATE act SET betweenness_weight=0.0240963855421686 WHERE id=301;
UPDATE act SET betweenness_weight=1606.2753729381460 WHERE id=302;
UPDATE act SET betweenness_weight=423.10876457596770 WHERE id=303;
UPDATE act SET betweenness_weight=392.35153502618493 WHERE id=304;
UPDATE act SET betweenness_weight=88.853990467789370 WHERE id=305;
UPDATE act SET betweenness_weight=4676.6087444550820 WHERE id=306;
UPDATE act SET betweenness_weight=16.479343090520810 WHERE id=307;
UPDATE act SET betweenness_weight=114.26810415162092 WHERE id=308;
UPDATE act SET betweenness_weight=8.3395101848024920 WHERE id=309;
UPDATE act SET betweenness_weight=36.351473423029994 WHERE id=310;
UPDATE act SET betweenness_weight=1991.7124365873817 WHERE id=311;
UPDATE act SET betweenness_weight=447.69567057853090 WHERE id=312;
UPDATE act SET betweenness_weight=1.7898721161879059 WHERE id=313;
UPDATE act SET betweenness_weight=15.566303251503593 WHERE id=314;
UPDATE act SET betweenness_weight=353.91262222764500 WHERE id=315;
UPDATE act SET betweenness_weight=25.642288912489605 WHERE id=316;
UPDATE act SET betweenness_weight=439.59458513570690 WHERE id=317;
UPDATE act SET betweenness_weight=5231.2880447306330 WHERE id=318;
UPDATE act SET betweenness_weight=2961.4566909076366 WHERE id=319;
UPDATE act SET betweenness_weight=22.464973872554120 WHERE id=320;
UPDATE act SET betweenness_weight=35.152637703698290 WHERE id=321;
UPDATE act SET betweenness_weight=1474.6721927909255 WHERE id=322;
UPDATE act SET betweenness_weight=3.7885492706482830 WHERE id=323;
UPDATE act SET betweenness_weight=373.82325363537470 WHERE id=324;
UPDATE act SET betweenness_weight=4.2390674603174600 WHERE id=325;
UPDATE act SET betweenness_weight=1045.1459807241072 WHERE id=326;
UPDATE act SET betweenness_weight=1163.5066221051770 WHERE id=327;
UPDATE act SET betweenness_weight=211.81954389010494 WHERE id=328;
UPDATE act SET betweenness_weight=697.70876943752280 WHERE id=329;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=330;
UPDATE act SET betweenness_weight=5.0378411816848200 WHERE id=331;
UPDATE act SET betweenness_weight=11262.253247869560 WHERE id=332;
UPDATE act SET betweenness_weight=29.122271452102100 WHERE id=333;
UPDATE act SET betweenness_weight=684.99999205556130 WHERE id=334;
UPDATE act SET betweenness_weight=42.663312459307490 WHERE id=335;
UPDATE act SET betweenness_weight=69.681765753568650 WHERE id=336;
UPDATE act SET betweenness_weight=19.750366266430850 WHERE id=337;
UPDATE act SET betweenness_weight=1716.2608770841084 WHERE id=338;
UPDATE act SET betweenness_weight=20.333701678997794 WHERE id=339;
UPDATE act SET betweenness_weight=186.85129906927537 WHERE id=340;
UPDATE act SET betweenness_weight=3370.2927730954210 WHERE id=341;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=342;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=343;
UPDATE act SET betweenness_weight=7.5694279508458510 WHERE id=344;
UPDATE act SET betweenness_weight=37.776574644722500 WHERE id=345;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=346;
UPDATE act SET betweenness_weight=230.95459126242557 WHERE id=347;
UPDATE act SET betweenness_weight=2310.2033492690620 WHERE id=348;
UPDATE act SET betweenness_weight=450.47417564734855 WHERE id=349;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=350;
UPDATE act SET betweenness_weight=83.797682231126840 WHERE id=351;
UPDATE act SET betweenness_weight=79.514366688255080 WHERE id=352;
UPDATE act SET betweenness_weight=165.62340384798364 WHERE id=353;
UPDATE act SET betweenness_weight=4.0009125444568230 WHERE id=354;
UPDATE act SET betweenness_weight=960.35595310492520 WHERE id=355;
UPDATE act SET betweenness_weight=1573.7665767029764 WHERE id=356;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=357;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=358;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=359;
UPDATE act SET betweenness_weight=830.26479029825570 WHERE id=360;
UPDATE act SET betweenness_weight=2528.9784627981317 WHERE id=361;
UPDATE act SET betweenness_weight=6.3714620399289865 WHERE id=362;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=363;
UPDATE act SET betweenness_weight=111.26231513927651 WHERE id=364;
UPDATE act SET betweenness_weight=0.0000000000000000 WHERE id=365;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
',
);
    }

}