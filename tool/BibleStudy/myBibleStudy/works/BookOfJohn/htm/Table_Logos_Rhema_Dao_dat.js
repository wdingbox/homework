
function tbdy_trs(){
    var trs="";
    trs+=tbdy_trs_by_Dat("Logos", Verese_John_Logos__Gre_NIV_CUV);
    trs+=tbdy_trs_by_Dat("Rhema", Verses_John_Rhema__Gre_NIV_CUV);

    return trs;
}
function tbdy_trs_by_Dat(name,da3){
    var i=0,trs="";
    var obj=da3[0];
    var keyArr=Object.keys(obj);
    $.each(keyArr, function(i,keyv){
        var cn="";
        trs+="<tr><td>"+i+"</td><td>"+keyv+"</td><td>"+name+"</td><td>"+cn+"</td><td>";
        $.each(da3,function(n,o){
            trs+=o[keyv]+"<br>";
        });
        trs+="</td></tr>";

    });

    return trs;
}
var Verese_John_Logos__Gre_NIV_CUV=[
    {
        "1:1": "ἐν ἀρχῇ ἦν ὁ <a class=\"logos\">λόγος</a>, καὶ ὁ <a class=\"logos\">λόγος</a> ἦν πρὸς τὸν θεόν, καὶ θεὸς ἦν ὁ <a class=\"logos\">λόγος</a>.",
        "1:14": "καὶ ὁ <a class=\"logos\">λόγος</a> σὰρξ ἐγένετο καὶ ἐσκήνωσεν ἐν ἡμῖν, καὶ ἐθεασάμεθα τὴν δόξαν αὐτοῦ, δόξαν ὡς μονογενοῦς παρὰ πατρός, πλήρης χάριτος καὶ ἀληθείας.",
        "2:22": "ὅτε οὗν ἠγέρθη ἐκ νεκρῶν, ἐμνήσθησαν οἱ μαθηταὶ αὐτοῦ ὅτι τοῦτο ἔλεγεν, καὶ ἐπίστευσαν τῇ γραφῇ καὶ τῶ <a class=\"logosw\">λόγῳ</a> ὃν εἶπεν ὁ ἰησοῦς.",
        "4:37": "ἐν γὰρ τούτῳ ὁ <a class=\"logos\">λόγος</a> ἐστὶν ἀληθινὸς ὅτι ἄλλος ἐστὶν ὁ σπείρων καὶ ἄλλος ὁ θερίζων.",
        "4:39": "ἐκ δὲ τῆς πόλεως ἐκείνης πολλοὶ ἐπίστευσαν εἰς αὐτὸν τῶν σαμαριτῶν διὰ τὸν <a class=\"logosv\">λόγον</a> τῆς γυναικὸς μαρτυρούσης ὅτι εἶπέν μοι πάντα ἃ ἐποίησα.",
        "4:41": "καὶ πολλῶ πλείους ἐπίστευσαν διὰ τὸν <a class=\"logosv\">λόγον</a> αὐτοῦ,",
        "4:50": "λέγει αὐτῶ ὁ ἰησοῦς, πορεύου· ὁ υἱός σου ζῇ. ἐπίστευσεν ὁ ἄνθρωπος τῶ <a class=\"logosw\">λόγῳ</a> ὃν εἶπεν αὐτῶ ὁ ἰησοῦς καὶ ἐπορεύετο.",
        "5:24": "5:24  Ἀμὴν ἀμὴν λέγω ὑμῖν ὅτι ὁ τὸν λόγον μου ἀκούων καὶ πιστεύων τῷ πέμψαντί με ἔχει ζωὴν αἰώνιον καὶ εἰς κρίσιν οὐκ ἔρχεται ἀλλὰ μεταβέβηκεν ἐκ τοῦ θανάτου εἰς τὴν ζωήν",
        "5:38": "καὶ τὸν <a class=\"logosv\">λόγον</a> αὐτοῦ οὐκ ἔχετε ἐν ὑμῖν μένοντα, ὅτι ὃν ἀπέστειλεν ἐκεῖνος τούτῳ ὑμεῖς οὐ πιστεύετε.",
        "6:60": "πολλοὶ οὗν ἀκούσαντες ἐκ τῶν μαθητῶν αὐτοῦ εἶπαν, σκληρός ἐστιν ὁ <a class=\"logos\">λόγος</a> οὖτος· τίς δύναται αὐτοῦ ἀκούειν;",
        "7:36": "τίς ἐστιν ὁ <a class=\"logos\">λόγος</a> οὖτος ὃν εἶπεν, ζητήσετέ με καὶ οὐχ εὑρήσετέ [με], καὶ ὅπου εἰμὶ ἐγὼ ὑμεῖς οὐ δύνασθε ἐλθεῖν;",
        "7:40": "ἐκ τοῦ ὄχλου οὗν ἀκούσαντες τῶν <a class=\"logoswv\">λόγων</a> τούτων ἔλεγον, οὖτός ἐστιν ἀληθῶς ὁ προφήτης·",
        "8:31": "ἔλεγεν οὗν ὁ ἰησοῦς πρὸς τοὺς πεπιστευκότας αὐτῶ ἰουδαίους, ἐὰν ὑμεῖς μείνητε ἐν τῶ <a class=\"logosw\">λόγῳ</a> τῶ ἐμῶ, ἀληθῶς μαθηταί μού ἐστε,",
        "8:37": "οἶδα ὅτι σπέρμα ἀβραάμ ἐστε· ἀλλὰ ζητεῖτέ με ἀποκτεῖναι, ὅτι ὁ <a class=\"logos\">λόγος</a> ὁ ἐμὸς οὐ χωρεῖ ἐν ὑμῖν.",
        "8:43": "διὰ τί τὴν λαλιὰν τὴν ἐμὴν οὐ γινώσκετε; ὅτι οὐ δύνασθε ἀκούειν τὸν <a class=\"logosv\">λόγον</a> τὸν ἐμόν.",
        "8:51": "ἀμὴν ἀμὴν λέγω ὑμῖν, ἐάν τις τὸν ἐμὸν <a class=\"logosv\">λόγον</a> τηρήσῃ, θάνατον οὐ μὴ θεωρήσῃ εἰς τὸν αἰῶνα.",
        "8:52": "εἶπον [οὗν] αὐτῶ οἱ ἰουδαῖοι, νῦν ἐγνώκαμεν ὅτι δαιμόνιον ἔχεις. ἀβραὰμ ἀπέθανεν καὶ οἱ προφῆται, καὶ σὺ λέγεις, ἐάν τις τὸν <a class=\"logosv\">λόγον</a> μου τηρήσῃ, οὐ μὴ γεύσηται θανάτου εἰς τὸν αἰῶνα.",
        "8:55": "καὶ οὐκ ἐγνώκατε αὐτόν, ἐγὼ δὲ οἶδα αὐτόν. κἂν εἴπω ὅτι οὐκ οἶδα αὐτόν, ἔσομαι ὅμοιος ὑμῖν ψεύστης· ἀλλὰ οἶδα αὐτὸν καὶ τὸν <a class=\"logosv\">λόγον</a> αὐτοῦ τηρῶ.",
        "10:19": "σχίσμα πάλιν ἐγένετο ἐν τοῖς ἰουδαίοις διὰ τοὺς <a class=\"logosvc\"></a><a class=\"logov\">λόγου</a>ς τούτους.",
        "10:35": "εἰ ἐκείνους εἶπεν θεοὺς πρὸς οὓς ὁ <a class=\"logos\">λόγος</a> τοῦ θεοῦ ἐγένετο, καὶ οὐ δύναται λυθῆναι ἡ γραφή,",
        "12:38": "ἵνα ὁ <a class=\"logos\">λόγος</a> ἠσαΐου τοῦ προφήτου πληρωθῇ ὃν εἶπεν, κύριε, τίς ἐπίστευσεν τῇ ἀκοῇ ἡμῶν; καὶ ὁ βραχίων κυρίου τίνι ἀπεκαλύφθη;",
        "12:48": "ὁ ἀθετῶν ἐμὲ καὶ μὴ λαμβάνων τὰ ῥήματά μου ἔχει τὸν κρίνοντα αὐτόν· ὁ <a class=\"logos\">λόγος</a> ὃν ἐλάλησα ἐκεῖνος κρινεῖ αὐτὸν ἐν τῇ ἐσχάτῃ ἡμέρᾳ·",
        "14:23": "ἀπεκρίθη ἰησοῦς καὶ εἶπεν αὐτῶ, ἐάν τις ἀγαπᾷ με τὸν <a class=\"logosv\">λόγον</a> μου τηρήσει, καὶ ὁ πατήρ μου ἀγαπήσει αὐτόν, καὶ πρὸς αὐτὸν ἐλευσόμεθα καὶ μονὴν παρ᾽ αὐτῶ ποιησόμεθα.",
        "14:24": "ὁ μὴ ἀγαπῶν με τοὺς <a class=\"logosvc\"></a><a class=\"logov\">λόγου</a>ς μου οὐ τηρεῖ· καὶ ὁ <a class=\"logos\">λόγος</a> ὃν ἀκούετε οὐκ ἔστιν ἐμὸς ἀλλὰ τοῦ πέμψαντός με πατρός.",
        "15:3": "ἤδη ὑμεῖς καθαροί ἐστε διὰ τὸν <a class=\"logosv\">λόγον</a> ὃν λελάληκα ὑμῖν·",
        "15:20": "μνημονεύετε τοῦ <a class=\"logov\">λόγου</a> οὖ ἐγὼ εἶπον ὑμῖν, οὐκ ἔστιν δοῦλος μείζων τοῦ κυρίου αὐτοῦ. εἰ ἐμὲ ἐδίωξαν, καὶ ὑμᾶς διώξουσιν· εἰ τὸν <a class=\"logosv\">λόγον</a> μου ἐτήρησαν, καὶ τὸν ὑμέτερον τηρήσουσιν.",
        "15:25": "ἀλλ᾽ ἵνα πληρωθῇ ὁ <a class=\"logos\">λόγος</a> ὁ ἐν τῶ νόμῳ αὐτῶν γεγραμμένος ὅτι ἐμίσησάν με δωρεάν.",
        "17:6": "ἐφανέρωσά σου τὸ ὄνομα τοῖς ἀνθρώποις οὓς ἔδωκάς μοι ἐκ τοῦ κόσμου. σοὶ ἦσαν κἀμοὶ αὐτοὺς ἔδωκας, καὶ τὸν <a class=\"logosv\">λόγον</a> σου τετήρηκαν.",
        "17:14": "ἐγὼ δέδωκα αὐτοῖς τὸν <a class=\"logosv\">λόγον</a> σου, καὶ ὁ κόσμος ἐμίσησεν αὐτούς, ὅτι οὐκ εἰσὶν ἐκ τοῦ κόσμου καθὼς ἐγὼ οὐκ εἰμὶ ἐκ τοῦ κόσμου.",
        "17:17": "ἁγίασον αὐτοὺς ἐν τῇ ἀληθείᾳ· ὁ <a class=\"logos\">λόγος</a> ὁ σὸς ἀλήθειά ἐστιν.",
        "17:20": "οὐ περὶ τούτων δὲ ἐρωτῶ μόνον, ἀλλὰ καὶ περὶ τῶν πιστευόντων διὰ τοῦ <a class=\"logov\">λόγου</a> αὐτῶν εἰς ἐμέ,",
        "18:9": "ἵνα πληρωθῇ ὁ <a class=\"logos\">λόγος</a> ὃν εἶπεν ὅτι οὓς δέδωκάς μοι οὐκ ἀπώλεσα ἐξ αὐτῶν οὐδένα.",
        "18:32": "ἵνα ὁ <a class=\"logos\">λόγος</a> τοῦ ἰησοῦ πληρωθῇ ὃν εἶπεν σημαίνων ποίῳ θανάτῳ ἤμελλεν ἀποθνῄσκειν.",
        "19:8": "ὅτε οὗν ἤκουσεν ὁ πιλᾶτος τοῦτον τὸν <a class=\"logosv\">λόγον</a>, μᾶλλον ἐφοβήθη,",
        "19:13": "ὁ οὗν πιλᾶτος ἀκούσας τῶν <a class=\"logoswv\">λόγων</a> τούτων ἤγαγεν ἔξω τὸν ἰησοῦν, καὶ ἐκάθισεν ἐπὶ βήματος εἰς τόπον λεγόμενον λιθόστρωτον, ἑβραϊστὶ δὲ γαββαθα.",
        "21:23": "ἐξῆλθεν οὗν οὖτος ὁ <a class=\"logos\">λόγος</a> εἰς τοὺς ἀδελφοὺς ὅτι ὁ μαθητὴς ἐκεῖνος οὐκ ἀποθνῄσκει. οὐκ εἶπεν δὲ αὐτῶ ὁ ἰησοῦς ὅτι οὐκ ἀποθνῄσκει, ἀλλ᾽, ἐὰν αὐτὸν θέλω μένειν ἕως ἔρχομαι [, τί πρὸς σέ];"
    },
    {
        "1:1": "In the beginning was <span style=\"color:#ff0000;\">the Word</span>, and <span style=\"color:#ff0000;\">the Word</span> was with God, and <span style=\"color:#ff0000;\">the Word</span> was God.",
        "1:14": "<span style=\"color:#ff0000;\">The Word</span> became flesh and made his dwelling among us. We have seen his glory, the glory of the one and only Son, who came from the Father, full of grace and truth.",
        "2:22": "After he was raised from the dead, his disciples recalled what he had said. Then they believed the scripture and the words that Jesus had spoken.",
        "4:37": "Thus the saying ‘One sows and another reaps' is true.",
        "4:39": "Many of the Samaritans from that town believed in him because of the woman's testimony, “He told me everything I ever did.”",
        "4:41": "And because of his words many more became believers.",
        "4:50": "“Go,” Jesus replied, “your son will live.” The man took Jesus at his word and departed.",
        "5:24": "“Very truly I tell you, whoever hears my word and believes him who sent me has eternal life and will not be judged but has crossed over from death to life.",
        "5:38": "nor does his word dwell in you, for you do not believe the one he sent.",
        "6:60": "On hearing it, many of his disciples said, “This is a hard teaching. Who can accept it?”",
        "7:36": "What did he mean when he said, ‘You will look for me, but you will not find me,' and ‘Where I am, you cannot come'?”",
        "7:40": "On hearing his words, some of the people said, “Surely this man is the Prophet.”",
        "8:31": "To the Jews who had believed him, Jesus said, “If you hold to my teaching, you are really my disciples.",
        "8:37": "I know that you are Abraham’s descendants. Yet you are looking for a way to kill me, because you have no room for my word.",
        "8:43": "Why is my language not clear to you? Because you are unable to hear what I say.",
        "8:51": "Very truly I tell you, whoever obeys my word will never see death.”",
        "8:52": "At this they exclaimed, “Now we know that you are demon-possessed! Abraham died and so did the prophets, yet you say that whoever obeys your word will never taste death.",
        "8:55": "Though you do not know him, I know him. If I said I did not, I would be a liar like you, but I do know him and obey his word.",
        "10:19": "The Jews who heard these words were again divided",
        "10:35": "If he called them ‘gods,’ to whom the word of God came—and Scripture cannot be set aside—",
        "12:38": "This was to fulfill the word of Isaiah the prophet: “Lord, who has believed our message and to whom has the arm of the Lord been revealed?”[fn]",
        "12:48": "There is a judge for the one who rejects me and does not accept my words; the very words I have spoken will condemn them at the last day.",
        "14:23": "esus replied, “Anyone who loves me will obey my teaching. My Father will love them, and we will come to them and make our home with them.",
        "14:24": "Anyone who does not love me will not obey my teaching. These words you hear are not my own; they belong to the Father who sent me.",
        "15:3": "You are already clean because of the word I have spoken to you.",
        "15:20": "Remember what I told you: ‘A servant is not greater than his master.’[fn] If they persecuted me, they will persecute you also. If they obeyed my teaching, they will obey yours also.",
        "15:25": "But this is to fulfill what is written in their Law: ‘They hated me without reason.’[fn]",
        "17:6": "“I have revealed you[fn] to those whom you gave me out of the world. They were yours; you gave them to me and they have obeyed your word.",
        "17:14": "I have given them your word and the world has hated them, for they are not of the world any more than I am of the world.",
        "17:17": "Sanctify them by[fn] the truth; your word is truth.",
        "17:20": "“My prayer is not for them alone. I pray also for those who will believe in me through their message,",
        "18:9": "This happened so that the words he had spoken would be fulfilled: “I have not lost one of those you gave me.”[fn]",
        "18:32": "This took place to fulfill what Jesus had said about the kind of death he was going to die.",
        "19:8": "When Pilate heard this, he was even more afraid,",
        "19:13": "When Pilate heard this, he brought Jesus out and sat down on the judge’s seat at a place known as the Stone Pavement (which in Aramaic is Gabbatha).",
        "21:23": "Because of this, the rumor spread among the believers that this disciple would not die. But Jesus did not say that he would not die; he only said, “If I want him to remain alive until I return, what is that to you?”"
    },
    {
        "1:1": "太初有<a class=\"dao\">道</a> ， <a class=\"dao\">道</a>與神同在 ， <a class=\"dao\">道</a>就是神 。",
        "1:14": "<a class=\"dao\">道</a>成了肉身 ， 住在我們中間 ， 充充滿滿的有恩典有真理 。 我們也見過他的榮光 ， 正是父獨生子的榮光 。",
        "2:22": "所以到他從死裡復活以後 ， 門徒就想起他說過這話 ， 便信了聖經和耶穌所說的 。",
        "4:37": "俗語說 ：『 那人撒種 ， 這人收割 』 ， 這話可見是真的 。",
        "4:39": "那城裡有好些撒瑪利亞人信了耶穌 ， 因為那婦人作見證說 ： 「 他將我素來所行的一切事都給我說出來了」",
        "4:41": "因耶穌的<a class=\"dao\">話</a> ， 信的人就更多了.",
        "4:50": "耶穌對他說 ： 「 回去吧 ， 你的兒子活了 ！ 」 那人信耶穌所說的話就回去了 。",
        "5:24": "我實實在在的告訴你們 ， 那聽我<a class=\"dao\">話</a> 、 又信差我來者的 ， 就有永生 ； 不至於定罪 ， 是已經出死入生了&nbsp;",
        "5:38": "你們並沒有他的<a class=\"dao\">道</a>存在心裡 ； 因為他所差來的 ， 你們不信 。",
        "6:60": "他的門徒中有好些人聽見了 ， 就說 ： 這<a class=\"dao\">話</a>甚難 ， 誰能聽呢 ？",
        "7:36": "祂<a class=\"dao\">说</a>我们找不到祂，又不能去祂所在的地方，是什么意思？”",
        "7:40": "听见这些<a class=\"dao\">话</a>后，有些人说：“祂真是那位先知。”",
        "8:31": "耶 穌 對 信 他 的 猶 太 人 說 ： 你 們 若 常 常 遵 守 我 的 <a class=\"dao\">道</a> ， 就 真 是 我 的 門 徒 ；",
        "8:37": "“我知<a class=\"dao\">道</a>你们是亚伯拉罕的子孙，但你们却想杀我，因为你们心里容不下我的<a class=\"dao\">道</a>。",
        "8:43": "你们为什么不明白我的话呢？因为你们听不进去我的<a class=\"dao\">道</a>。",
        "8:51": "我实实在在地告诉你们，人如果遵行我的<a class=\"dao\">道</a>，必永远不死。”",
        "8:52": "那些犹太人说：“现在我们的确知<a class=\"dao\">道</a>你是被鬼附身了！亚伯拉罕和众先知都死了，你还说人如果遵行你的<a class=\"dao\">道</a>，必永远不死。",
        "8:55": "你们不认识祂，我却认识祂。如果我说我不认识祂，那我就像你们一样是说谎的。然而，我认识祂，并且遵行祂的<a class=\"dao\">道</a>。",
        "10:19": "犹太人因这番<a class=\"dao\">话</a>又起了纷争。",
        "10:35": "圣经上的话是不能废的，既然上帝称那些承受祂<a class=\"dao\">道</a>的人为神，",
        "12:38": "这是要应验以赛亚先知的<a class=\"dao\">话</a>：“主啊，谁相信我们所传的呢？主的能力[a]向谁显现呢？”",
        "12:48": "弃绝我、不接受我话的人将受到审判，我讲过的<a class=\"dao\">道</a>在末日要审判他",
        "14:23": "耶稣回答说：“爱我的人必遵行我的<a class=\"dao\">道</a>，我父也必爱他，并且我们要到他那里与他同住。",
        "14:24": "不愛我的人就不遵守我的<a class=\"dao\">道</a>。你們所聽見的道不是我的，乃是差我來之父的道。",
        "15:3": "不爱我的人不会遵行我的<a class=\"dao\">道</a>。你们所听见的<a class=\"dao\">道</a>不是出于我自己，而是出于差我来的父。",
        "15:20": "你们要记住我说的<a class=\"dao\">话</a>，‘奴仆不能大过主人。’他们若迫害我，也必迫害你们；他们若遵行我的话，也必遵行你们的话。",
        "15:25": "这是要应验他们律法书上的<a class=\"dao\">话</a>，‘他们无故地恨我。’",
        "17:6": "“你从世上赐给我的人，我已将你[a]显明给他们。他们本来属于你，你将他们赐给了我，他们遵守你的<a class=\"dao\">道</a>",
        "17:14": "我已将你的<a class=\"dao\">道</a>赐给他们，世人恨他们，因为他们像我一样不属于这个世界。",
        "17:17": "求你用真理，就是你的<a class=\"dao\">道</a>，使他们圣洁。",
        "17:20": "“我不但为这些人祈求，也为那些因他们的<a class=\"dao\">话</a>而信我的人祈求，",
        "18:9": "这是要应验祂以前<a class=\"dao\">说</a>的：“你赐给我的人一个也没有失掉。”",
        "18:32": "这是要应验耶稣预言自己会怎样死的<a class=\"dao\">话</a>。",
        "19:8": "彼拉多听了这<a class=\"dao\">话</a>，更加害怕，",
        "19:13": "彼拉多听了这<a class=\"dao\">话</a>，就带着耶稣来到一个地方，名叫“铺石地”，那地方希伯来话叫厄巴大。彼拉多在那里开庭审判祂。",
        "21:23": "于是在信徒中间就传说那个门徒不会死。其实耶稣并没有说他不会死，只是<a class=\"dao\">说</a>：“如果我要他活到我再来，与你有什么关系？”"
    }
]
var Verses_John_Rhema=["3:34", "5:47","6:63","6:68","8:20","8:47","10:21","12:47","12:48","14:10","15:7","17:8"];	

var Verses_John_Rhema__Gre_NIV_CUV=[
{
"3:34":"ὃν γὰρ ἀπέστειλεν ὁ θεὸς τὰ <a class='rhema'>ῥήματα</a> τοῦ θεοῦ λαλεῖ οὐ γὰρ ἐκ μέτρου δίδωσιν ὁ Θεὸς τὸ πνεῦμα",
"5:47":"εἰ δὲ τοῖς ἐκείνου γράμμασιν οὐ πιστεύετε πῶς τοῖς ἐμοῖς <a class='rhema'>ῥήμασιν</a> πιστεύσετε",
"6:63":"τὸ πνεῦμά ἐστιν τὸ ζῳοποιοῦν ἡ σὰρξ οὐκ ὠφελεῖ οὐδέν τὰ ῥήματα ἃ ἐγὼ λαλῶ ὑμῖν πνεῦμά ἐστιν καὶ ζωή ἐστιν",
"6:68":"ἀπεκρίθη αὐτῶ σίμων πέτρος, κύριε, πρὸς τίνα ἀπελευσόμεθα; <a class=\"rhema\">ῥήματα</a> ζωῆς αἰωνίου ἔχεις,",
"8:20":"Ταῦτα τὰ ῥήματα ἐλάλησεν ὁ Ἰησοῦς ἐν τῷ γαζοφυλακίῳ διδάσκων ἐν τῷ ἱερῷ καὶ οὐδεὶς ἐπίασεν αὐτόν ὅτι οὔπω ἐληλύθει ἡ ὥρα αὐτοῦ",
"8:47":"ὁ ὢν ἐκ τοῦ θεοῦ τὰ ῥήματα τοῦ θεοῦ ἀκούει διὰ τοῦτο ὑμεῖς οὐκ ἀκούετε ὅτι ἐκ τοῦ θεοῦ οὐκ ἐστέ",
"10:21":"ἄλλοι ἔλεγον Ταῦτα τὰ ῥήματα οὐκ ἔστιν δαιμονιζομένου μὴ δαιμόνιον δύναται τυφλῶν ὀφθαλμοὺς ἀνοίγειν",
"12:47":"καὶ ἐάν τίς μου ἀκούσῃ τῶν ῥημάτων καὶ μὴ πιστεύσῃ ἐγὼ οὐ κρίνω αὐτόν οὐ γὰρ ἦλθον ἵνα κρίνω τὸν κόσμον ἀλλ᾽ ἵνα σώσω τὸν κόσμον",
"12:48":"ὁ ἀθετῶν ἐμὲ καὶ μὴ λαμβάνων τὰ ῥήματά μου ἔχει τὸν κρίνοντα αὐτόν ὁ λόγος ὃν ἐλάλησα ἐκεῖνος κρινεῖ αὐτὸν ἐν τῇ ἐσχάτῃ ἡμέρᾳ",
"14:10":"οὐ πιστεύεις ὅτι ἐγὼ ἐν τῷ πατρὶ καὶ ὁ πατὴρ ἐν ἐμοί ἐστιν τὰ ῥήματα ἃ ἐγὼ λαλῶ ὑμῖν ἀπ᾽ ἐμαυτοῦ οὐ λαλῶ ὁ δὲ πατὴρ ὁ ἐν ἐμοὶ μένων αὐτὸς ποιεῖ τὰ ἔργα",
"15:7" :"ἐὰν μείνητε ἐν ἐμοὶ καὶ τὰ ῥήματά μου ἐν ὑμῖν μείνῃ ὃ ἐὰν θέλητε αἰτήσεσθε καὶ γενήσεται ὑμῖν",
"17:8" :"ὅτι τὰ ῥήματα ἃ δέδωκάς μοι δέδωκα αὐτοῖς καὶ αὐτοὶ ἔλαβον καὶ ἔγνωσαν ἀληθῶς ὅτι παρὰ σοῦ ἐξῆλθον καὶ ἐπίστευσαν ὅτι σύ με ἀπέστειλας",
},
{
"3:34":"神所差來的就說神的話，因為神賜聖靈給他是沒有限量的。",
"5:47":"你們若不信他的書，怎能信我的話呢？",
"6:63":"叫人活著的乃是靈，肉體是無益的。我對你們所說的話就是靈，就是生命。",
"6:68":"西門彼得回答說：主阿，你有永生之道，我們還歸從誰呢？",
"8:20":"這些話是耶穌在殿裡的庫房、教訓人時所說的，也沒有人拿他，因為他的時候還沒有到。",
"8:47":"出於神的，必聽神的話；你們不聽，因為你們不是出於神。",
"10:21":"又有人說：這不是鬼附之人所說的話。鬼豈能叫瞎子的眼睛開了呢？",
"12:47":"若有人聽見我的話不遵守，我不審判他。我來本不是要審判世界，乃是要拯救世界。",
"12:48":"棄絕我、不領受我話的人，有審判他的─就是我所講的道在末日要審判他。",
"14:10":"我在父裡面，父在我裡面，你不信麼？我對你們所說的話，不是憑著自己說的，乃是住在我裡面的父做他自己的事。",
"15:7":"你們若常在我裡面，我的話也常在你們裡面，凡你們所願意的，祈求，就給你們成就。",
"17:8":"因為你所賜給我的道，我已經賜給他們，他們也領受了，又確實知道，我是從你出來的，並且信你差了我來。",
},
{
"3:34":"For the one whom God has sent speaks the words of God, for God[a] gives the Spirit without limit.",
"5:47":"But since you do not believe what he wrote, how are you going to believe what I say?",
"6:63":"The Spirit gives life; the flesh counts for nothing. The words I have spoken to you—they are full of the Spirit[a] and life.",
"6:68":"Simon Peter answered him, “Lord, to whom shall we go? You have the words of eternal life.",
"8:20":"He spoke these words while teaching in the temple courts near the place where the offerings were put. Yet no one seized him, because his hour had not yet come.",
"8:47":"Whoever belongs to God hears what God says. The reason you do not hear is that you do not belong to God.",
"10:21":"But others said, “These are not the sayings of a man possessed by a demon. Can a demon open the eyes of the blind?",
"12:47":"“If anyone hears my words but does not keep them, I do not judge that person. For I did not come to judge the world, but to save the world.",
"12:48":"There is a judge for the one who rejects me and does not accept my words; the very words I have spoken will condemn them at the last day.",
"14:10":"Don’t you believe that I am in the Father, and that the Father is in me? The words I say to you I do not speak on my own authority. Rather, it is the Father, living in me, who is doing his work.",
"15:7":"If you remain in me and my words remain in you, ask whatever you wish, and it will be done for you.",
"17:8":"For I gave them the words you gave me and they accepted them. They knew with certainty that I came from you, and they believed that you sent me.",
}
];





