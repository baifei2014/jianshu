<?Php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="wraps">
<div class="blog-default-about">
    <div class="blog-header">
        <h4><?=Html::a('蒋龙豪的个人网站',Url::to('index.php'),['class' => 'bread links1'])?><small>&nbsp;>></small></h4>
    </div>
    <div class="about-container">
        <h2>关于蒋龙豪</h2>
        <div class="post-content">
            <div class="introduce-images">
                <a href="javascript:;" class=""><img src="statics/images/6.jpg"></a>
            </div>
            <div class="introduce-summary">
                <h4>个人概况</h4>
                <h5 class="title3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;作为一个程序员，用简单的代码来描述自己，或许再恰当不过了。如果你还是习惯常规的文字描述，请&nbsp;<a href="#module1" class="button1">点击这里</a></h5>
            </div>
        </div>
        <div class="post-menus">
            <ul>
                <li><a href="javascript:;" class="active">Javascript::Me</a></li>
                <li><a href="javascript:;" class="">PHP::Me</a></li>
                <li><a href="javascript:;" class="">C++::Me</a></li>
            </ul>
        </div>
        <div class="post-menu-detail">
            <ul>
                <li id="tab1">
                    <h5>
                    <table class="code-intro">
                        <tbody>
                            <tr class="code-intro-title">
                                <td></td>
                                <td>javascript</td>
                            </tr>
                            <tr>
                                <td class="line">
                                    <p class="line1">1</p>
                                    <p class="line2">2</p>
                                    <p class="line1">3</p>
                                    <p class="line2">4</p>
                                    <p class="line1">5</p>
                                    <p class="line2">6</p>
                                    <p class="line1">7</p>
                                    <p class="line2">8</p>
                                    <p class="line1">9</p>
                                    <p class="line2">10</p>
                                    <p class="line1">11</p>
                                    <p class="line2">12</p>
                                    <p class="line1">13</p>
                                    <p class="line2">14</p>
                                    <p class="line1">15</p>
                                    <p class="line2">16</p>
                                    <p class="line1">17</p>
                                    <p class="line2">18</p>
                                    <p class="line1">19</p>
                                    <p class="line2">20</p>
                                    <p class="line1">21</p>
                                    <p class="line2">22</p>
                                    <p class="line1">23</p>
                                    <p class="line2">24</p>
                                    <p class="line1">25</p>
                                    <p class="line2">26</p>
                                    <p class="line1">27</p>
                                    <p class="line2">28</p>
                                </td>
                                <td>
                                    <p class="code1">(function(IM,SUYANG,SINCE){</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>var now=new Date;</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>var profile = {</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'姓名'    :'苏洋',</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'年龄'    :(now.getFullYear()-SINCE),</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'性别'    :'男',</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'标签'    :['水瓶座','宅','前端er'],</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'喜欢'    :['计算机','互联网','编程','前端','交互设计','音乐','动漫','零食...'],</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'家乡'    :'山西太原'</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>}</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>varSY=function(data){</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.profile=profile;</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>varthat=this;</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.Dream='成为受人尊重的程序员...';</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.profile.昵称=IM;</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.profile.状态=SUYANG;</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.OwnDream=function(){returnthat.profile.梦想=that.Dream;}</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.SelfIntro=function(){</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>for(tag inthat.profile){</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>if('object'==typeof(that.profile[tag])){that.profile[tag]=that.profile[tag].join(', ');}</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>console.log(tag+':',that.profile[tag]);</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>}</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>}</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>};</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>varme=newSY();</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>me.OwnDream();</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>me.SelfIntro();</p>
                                    <p class="code2">})('soulteary','Working hard and day day up! :-)',1989)</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </h5>
                </li>
                <li id="tab2" style="display: none;">
                    <h5>
                    <table class="code-intro">
                        <tbody>
                            <tr class="code-intro-title">
                                <td></td>
                                <td>PHP</td>
                            </tr>
                            <tr>
                                <td class="line">
                                    <p class="line1">1</p>
                                    <p class="line2">2</p>
                                    <p class="line1">3</p>
                                    <p class="line2">4</p>
                                    <p class="line1">5</p>
                                    <p class="line2">6</p>
                                    <p class="line1">7</p>
                                    <p class="line2">8</p>
                                    <p class="line1">9</p>
                                    <p class="line2">10</p>
                                    <p class="line1">11</p>
                                    <p class="line2">12</p>
                                    <p class="line1">13</p>
                                    <p class="line2">14</p>
                                    <p class="line1">15</p>
                                    <p class="line2">16</p>
                                    <p class="line1">17</p>
                                    <p class="line2">18</p>
                                    <p class="line1">19</p>
                                    <p class="line2">20</p>
                                    <p class="line1">21</p>
                                    <p class="line2">22</p>
                                    <p class="line1">23</p>
                                    <p class="line2">24</p>
                                    <p class="line1">25</p>
                                    <p class="line2">26</p>
                                    <p class="line1">27</p>
                                    <p class="line2">28</p>
                                </td>
                                <td>
                                    <p class="code1">(function(IM,SUYANG,SINCE){</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>var now=new Date;</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>var profile = {</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'姓名'    :'苏洋',</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'年龄'    :(now.getFullYear()-SINCE),</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'性别'    :'男',</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'标签'    :['水瓶座','宅','前端er'],</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'喜欢'    :['计算机','互联网','编程','前端','交互设计','音乐','动漫','零食...'],</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'家乡'    :'山西太原'</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>}</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>varSY=function(data){</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.profile=profile;</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>varthat=this;</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.Dream='成为受人尊重的程序员...';</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.profile.昵称=IM;</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.profile.状态=SUYANG;</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.OwnDream=function(){returnthat.profile.梦想=that.Dream;}</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.SelfIntro=function(){</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>for(tag inthat.profile){</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>if('object'==typeof(that.profile[tag])){that.profile[tag]=that.profile[tag].join(', ');}</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>console.log(tag+':',that.profile[tag]);</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>}</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>}</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>};</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>varme=newSY();</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>me.OwnDream();</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>me.SelfIntro();</p>
                                    <p class="code2">})('soulteary','Working hard and day day up! :-)',1989)</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </h5>
                </li>
                <li id="tab3" style="display: none;">
                    <h5>
                    <table class="code-intro">
                        <tbody>
                            <tr class="code-intro-title">
                                <td></td>
                                <td>C++</td>
                            </tr>
                            <tr>
                                <td class="line">
                                    <p class="line1">1</p>
                                    <p class="line2">2</p>
                                    <p class="line1">3</p>
                                    <p class="line2">4</p>
                                    <p class="line1">5</p>
                                    <p class="line2">6</p>
                                    <p class="line1">7</p>
                                    <p class="line2">8</p>
                                    <p class="line1">9</p>
                                    <p class="line2">10</p>
                                    <p class="line1">11</p>
                                    <p class="line2">12</p>
                                    <p class="line1">13</p>
                                    <p class="line2">14</p>
                                    <p class="line1">15</p>
                                    <p class="line2">16</p>
                                    <p class="line1">17</p>
                                    <p class="line2">18</p>
                                    <p class="line1">19</p>
                                    <p class="line2">20</p>
                                    <p class="line1">21</p>
                                    <p class="line2">22</p>
                                    <p class="line1">23</p>
                                    <p class="line2">24</p>
                                    <p class="line1">25</p>
                                    <p class="line2">26</p>
                                    <p class="line1">27</p>
                                    <p class="line2">28</p>
                                </td>
                                <td>
                                    <p class="code1">(function(IM,SUYANG,SINCE){</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>var now=new Date;</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>var profile = {</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'姓名'    :'苏洋',</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'年龄'    :(now.getFullYear()-SINCE),</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'性别'    :'男',</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'标签'    :['水瓶座','宅','前端er'],</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'喜欢'    :['计算机','互联网','编程','前端','交互设计','音乐','动漫','零食...'],</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'家乡'    :'山西太原'</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>}</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>varSY=function(data){</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.profile=profile;</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>varthat=this;</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.Dream='成为受人尊重的程序员...';</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.profile.昵称=IM;</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.profile.状态=SUYANG;</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.OwnDream=function(){returnthat.profile.梦想=that.Dream;}</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>this.SelfIntro=function(){</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>for(tag inthat.profile){</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>if('object'==typeof(that.profile[tag])){that.profile[tag]=that.profile[tag].join(', ');}</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>console.log(tag+':',that.profile[tag]);</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>}</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>}</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>};</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>varme=newSY();</p>
                                    <p class="code2"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>me.OwnDream();</p>
                                    <p class="code1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>me.SelfIntro();</p>
                                    <p class="code2">})('soulteary','Working hard and day day up! :-)',1989)</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </h5>
                </li>
            </ul>
        </div>
        <div id="module1">
        <div class="post-content">
            <div class="simple-intro">
                <h4>简单概述</h4>
                <h5 class="title3 simple-content">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我是一个程序员里的小学生，喜欢学习和了解新的东西，对技术方面的东西很感兴趣，正在一步步的进步和学习，Yes It's Me，在平常的生活中，我也喜欢打球，看电影，热爱生活并喜欢旅行，乐观开朗是我的座右铭，努力进取是我的人生格言，并且希望用自己的努力换来自己想要的生活。
                </h5>
            </div>
            <div class="person-links">
                <h5 class="title3">我的联系方式&nbsp;:</h5>
                <div class="person-link">
                    <table class="linkse">
                        <tbody>
                            <tr>
                                <td><span>邮箱：</span></td>
                                <td><span class="number">759395919@qq.com</span></td>
                            </tr>
                            <tr>
                                <td><span>QQ：</span></td>
                                <td><span class="number">759395919</span></td>
                            </tr>
                            <tr>
                                <td><span>微信：</span></td>
                                <td><span class="number">JLH759395919</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
        <div class="post-content">
            <div class="simple-intro">
                <h4>我的想法</h4>
                <h5 class="title3 simple-content">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;一个90后，有着年轻人的激动和热血，随着时间的变化也越来越稳重，相比于淡然的接受一切，我更喜欢接受挑战的生活，有着一股不服气的劲，不是什么专业的计算机专业，但就是比较喜欢这个职业，想着也靠编程混口饭吃，不知道会怎样，但会努力做下去。
                </h5>
            </div>
        </div>
    </div>
</div>
</div>
<script src="statics/js/jquery.js"></script>
<script>
    $('.post-menus ul li')
    .click(function(){
        var i = $('.post-menus ul li').index(this);
        $('.post-menus ul li').children().removeClass("active");
        $('.post-menus ul li').eq(i).children().addClass("active");
        $('.post-menu-detail ul li').css("display","none");
        $('.post-menu-detail ul li').eq(i).css("display","block");
    })
</script>
