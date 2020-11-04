
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>Coaster CMS | Admin home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="generator" content="Coaster CMS v5.3.9">
    <meta name="_token" content="vcN4qhBQInPOumG2R5W0P4micwC9x60HKZJxQMSe">

    <link href='https://fonts.googleapis.com/css?family=Raleway:400,100,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
    <link media="all" type="text/css" rel="stylesheet" href="{!!url('dist/assets/css')!!}/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="{!!url('dist/assets/app/css')!!}/main.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    
</head>

<body>

<nav class="navbar navbar-default navbar-fixhed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navissgation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="logo" href="{!!url('/')!!}">
                <img src="http://localhost:7000/coaster/app/img/logo.png" alt="Coaster CMS"/>
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{!!url('/')!!}" target="_blank">
                        <i class="fa fa-tv"></i> Open Frontend
                    </a>
                </li>
                <li>
                    <a href="{!!url('/')!!}" target="_blank">
                        <i class="fa fa-life-ring"></i> Help
                    </a>
                </li>
                <li>
                    <a href="{!!url('/')!!}">
                        <i class="fa fa-lock"></i> My Account
                    </a>
                </li>
                <li>
                    <a href="{!!url('/')!!}">
                        <i class="fa fa-cog"></i> System Settings
                    </a>
                </li>
                <li>
                    <a href="{!!url('/')!!}">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>

<nav class="navbar navbar-inverse subnav navbar-fixedg-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar2"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar2" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="dropdrown">
                    <a class="dropdrown-toggle" href="{!!url('/')!!}" >
                        <i class="fa fa-home"></i> Dashboard 
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle" href="{!!url('/')!!}" >
                        <i class="fa fa-file-text-o"></i> Pages 
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle" href="{!!url('/')!!}" >
                        <i class="fa fa-bars"></i> Menus 
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle" href="{!!url('/')!!}" >
                        <i class="fa fa-globe"></i> Site-wide Content 
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle" href="{!!url('/')!!}" >
                        <i class="fa fa-exchange"></i> Redirects 
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle" href="{!!url('/')!!}" >
                        <i class="fa fa-folder-open"></i> File Manager 
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle" href="{!!url('/')!!}" >
                        <i class="fa fa-user"></i> Users 
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle" href="{!!url('/')!!}" >
                        <i class="fa fa-bullhorn"></i> Roles 
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle" href="{!!url('/')!!}" >
                        <i class="fa fa-tint"></i> Theme 
                    </a>    
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle" href="{!!url('/')!!}" >
                        <i class="fa fa-bluetooth-b"></i> Beacons 
                    </a>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>


<div class="container" id="content-wrap">
    <div class="row">
        <div class="col-sm-12">
            <div id="cmsNotifications">
                <div class="alert" id="cmsDefaultNotification" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
            <h1>Dashboard</h1>
            <br/>

            <div class="row">
                <div class="col-md-8">
                    <div class="well well-home">
                        <div class="row">
                            <div class="col-md-7">
                                <h2>Hi <strong>admin@admin.co.id!</strong></h2>
                                <p>Welcome back to the Coaster CMS control panel.</p>
                                <p>Click on the pages menu item to start editing page specific content, or for content on more than one page go to site-wide content.</p>
                            </div>
                            <div class="col-md-5 text-center">
                                <a href="http://localhost:7000/admin/account" class="btn btn-default" style="margin-top:30px;">
                                    <i class="fa fa-lock"></i>  &nbsp; Account settings
                                </a>
                                <a href="http://www.coastercms.org/documentation/user-documentation" class="btn btn-default" style="margin-top:30px;">
                                    <i class="fa fa-life-ring"></i>  &nbsp; Help Docs
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="well well-home">
                        <h3><i class="fa fa-info-circle" aria-hidden="true"></i> Version Details</h3>
                        <ul>
                            <li><strong>Your site:</strong> v5.3.9</li>
                            <li><strong>Latest version:</strong> v5.3.20</li>
                        </ul>
                            <p><a class="btn btn-primary" href="http://localhost:7000/admin/system/upgrade">(upgrade)</a></p>
                            <p><a href="http://localhost:7000/admin/system" class="btn btn-default"><i class="fa fa-cog"></i> View all settings</a></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="well well-home well-blog">
                        <h3><i class="fa fa-rss" aria-hidden="true"></i> Latest from the Coaster Cms blog</h3>
                        <h4><a href="https://www.coastercms.org/blog/reviews-theyre-good/" target="_blank">The reviews are in, and they&#8217;re good</a></h4>
                        <p>Firstly, we’d like to say that we’re ecstatic to have been given an 8.2 (out of 10) on cmscritic.com. For a relatively small team to produce something that stands up to scrutiny alongside so many other systems is a huge achievement. Read the review here, if you haven’t already…

                        We feel a CMS built by a Digital Agency over several years has really helped keep the focus on the user ...</p>
                        <h4><a href="https://www.coastercms.org/blog/fixing-cloudflare-ssl-issues-with-coasterlaravel/" target="_blank">Fixing Cloudflare SSL Issues with Coaster/Laravel</a></h4>
                        <p>Cloudflare offers a great flexible SSL service allowing anyone to secure their site for free. Unfortunately, you can run into some issues straight out of the box as we ourselves found out when implementing Cloudflare’s SSL on this very site. For more established content management systems, Cloudflare does supply plugins that fix these problems without the need of additional code. However, in ...</p>
                                        <h4><a href="https://www.coastercms.org/blog/using-docker-and-coaster-cms/" target="_blank">Using Docker with Coaster CMS</a></h4>
                        <p>When it comes to running a virtualised development environment there are two highly debated options &#8211; Vagrant or Docker. Both of these have their pros and cons and for all intents and purposes, Laravel Homestead is still a great option for developing a Coaster project locally. However, for those who would rather use Docker we have come up with a solution.

                        What is Docker?
                        If you’re already ...</p>
                        <p><a class="btn btn-default" href="https://www.coastercms.org/blog/" target="_blank">Visit our blog</a></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="well well-home">
                    <h3><i class="fa fa-pencil" aria-hidden="true"></i> Site Updates</h3>
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>User</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Page 'Home Duplicate' deleted (Page ID 28)</td>
                            <td>admin@admin.co.id</td>
                            <td>7:21 AM 10/11/2016</td>
                            <td><a href="javascript:undo_log(3)">Restore</a></td>
                        </tr>            
                        <tr>
                            <td>2</td>
                            <td>Updated page 'Products' (Page ID 7)</td>
                            <td>admin@admin.co.id</td>
                            <td>7:20 AM 10/11/2016</td>
                            <td></td>
                        </tr>            
                        <tr>
                            <td>1</td>
                            <td>Setup CMS</td>
                            <td>admin@admin.co.id</td>
                            <td>6:58 AM 10/11/2016</td>
                            <td></td>
                        </tr>
                    </table>
                    <p><a class="btn btn-default" href="http://localhost:7000/admin/home/logs">View all admin logs</a></p>
                    </div>
                </div>
            </div>
            <br/><br />
        </div>
    </div>
</div>


<script src="{!!url('dist/assets/jquery')!!}/jquery-1.12.0.min.js"></script>
<script src="{!!url('dist/assets/bootstrap')!!}/js/bootstrap.min.js"></script>
<script src="{!!url('dist/assets/app/js')!!}/versions.js"></script>
<script src="{!!url('dist/assets/js')!!}/main.js"></script>
<script src="{!!url('dist/assets/app/js')!!}/functions.js"></script>


</body>

</html>
