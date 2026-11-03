# bdt222 বনাম BengalBet — বর্তমান মিল ও ঘাটতি

যাচাই: ৩ নভেম্বর ২০২৬। মূল প্রমাণ: সংরক্ষিত ১৩ অফারের লেখা, v3 ছবি/ধারা, বর্তমান source, লাইভ public settings ও নির্দিষ্ট readback। bdt222 নতুন করে সম্পূর্ণ ভিজিট করা হয়নি। পূর্ণ ১:১ সম্পন্ন বলা যাবে না।

## ইতিমধ্যে মেলে / নির্দিষ্টভাবে যাচাই
- নিজের থিম বজায়; desktop সদস্য কেন্দ্রের বাম মেনু বাস্তবে আছে। Browser-এ account, VIP, deposit, withdraw, bets, account records, profit/loss, rewards, referral, missions, messages, manual rebate—১২ মেনু দেখা হয়েছে। সব মেনুর সব কাজ এই audit-এ চালানো হয়নি।
- মোবাইলে home/promotion/share/reward/member পাঁচ বোতাম ও download bar আছে; সদস্য profile ও VIP পাতা browser-এ খোলা হয়েছে।
- লাইভ VIP0–VIP35, deposit_target=0; VIP1 bet2000/daily1, VIP35 bet4000000000/daily188888। পুরো VIP benefit টেবিল independent row-by-row যাচাই বাকি।
- referral300 deposit/3000 bet→300 এবং49 milestone; app500 deposit/5000 slot-fishing bet→52; login hammer200 deposit/1000 slot-fishing bet: আগের isolated live boundary checks pass।
- mystery23 ও rescue maximum80000 মালিকের স্থির সিদ্ধান্ত; পুনরায় জানতে হবে না।
- first-deposit tier model, daily-slot tiers, rebate tiers আগের যাচাইয়ের সঙ্গে মিলে; historical documents-এ পুরনো মান আছে, সেগুলো বর্তমান reference নয়।
- দৈনিক VIP card issuance/redemption একবার, ledger readback আগের live test-এ প্রমাণিত; historical prior-day member level নয়।
- এই audit-এ mobile daily salary benefit ও05:00 rule যোগ করা হয়েছে। Actual mobile390×844 VIP0-এ amount0 দেখা হয়েছে। Desktop1920×1080/member mobile-এ horizontal overflow বা page error নেই।96 frontend tests pass।

## নির্দিষ্ট অমিল
| বিষয় | bdt222 মূল লেখা / সিদ্ধান্ত | বর্তমানে |
|---|---|---|
| জমার সর্বনিম্ন | workflow100–50000 | live site_settings min200/max50000 |
| লাল খাম | মূল লেখা00,02,04,06,08,10,12,14,16,18,20,22;30min | live config00,12,16,20;30min/first50 |
| উদ্ধার সময় | রাত22:00, পরবর্তী24h; মূল লেখায় অর্থ/গ্রহণের wording অস্পষ্ট | previous-day loss claim before10:00 |
| সদস্য দিবস | 13তারিখ noon12:00 |13তারিখ; কোনোhour field নেই |
| mystery claim expiry | মূল লেখা30days | owned-card redemption-এ expiry guard নেই |
| wheel opportunity | deposit300+; একইদিন সুযোগ, nextday বাতিল | threshold300 মেলে; free_spins balance জমতে পারে, expiry নেই |
| দৈনিক VIP level | আগের দিনের level দাবি করা হয়েছিল | processing-time users.vip_level; historical snapshot নেই |
| cash prize / iPhone | wheel7–77777/iPhone; red1–77777 | admin chance table, cash-only settlement; physical prize workflow নেই |
| notification ও popup frequency | mobile consent; chest প্রতি পাতা observation | startup/login egg→chest→notice আছে; consent/frequency parity নেই |
| কৃত্রিম badges / stale defaults | actual member state | Sidebar3New; mobile profile কিছু static counts; VIP offline fallback পুরনো11tiers |

## সমাধান দরকার কিন্তু তথ্য অস্পষ্ট
- লাল খামের topup/bet threshold লেখা নেই; first50 আমাদের নিজস্ব সীমা—bdt222 মূল লেখা তা নির্দিষ্ট করে না।
- referral ongoing bet commission মূল লেখা slot/fishing1%; বর্তমান source-এ deposit0.7% অতিরিক্ত আছে। রাখা/বদল সিদ্ধান্ত দরকার।
- app-only অফার, physical iPhone delivery, sameIP restrictions সরাসরি কপি করলে বাস্তব যাচাই/পরিচালনা দরকার; সাধারণ browser user-কে মিথ্যা app-verified বলা যাবে না।
- daily VIP history না থাকলে পুরনো দিনের level অনুমান নয়; historical data policy দরকার।

## ইচ্ছাকৃত বাদ
নিজের থিম; points mall নেই; personal red-packet sending এখন নয়; hosting minute cron ও APK/iOS পরে। এগুলো missing implementation বলে পুনরায় প্রস্তাব নয়।

## পরের কাজ
১. মালিকের একত্রিত সিদ্ধান্ত।
২. সিদ্ধান্ত অনুসারে common rule config/server guards/frontend copy ও পরীক্ষা একসঙ্গে সংশোধন।
৩. admin save/readback এবং member desktop/mobile সব প্রাসঙ্গিক flow isolated account-এ পুনঃপরীক্ষা।
৪. stale60day model ও snapshots সংশোধন; simulation/live/browser ফল আলাদা রাখা।
৫. প্রতিটি ছবি, public/member destination, সব popup state ও সব financial boundary matrix শেষ না হওয়া পর্যন্ত total1:1 নয়।