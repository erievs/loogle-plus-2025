<?php
include '../assets/php/dependencies.php';
include '../important/config.php';
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0"> 

<script>

    (function () {
        var baseUrl = window.location.protocol + '//' + window.location.hostname;
        if (window.location.port) {
            baseUrl += ':' + window.location.port;
        }

        var icon = document.querySelector("link[rel~='icon']");
        if (icon) {
            icon.href = baseUrl + "/assets/site_images/favicon.png";
        }
    })();
</script>

<title>Account Managment</title>

<style type="text/css">
  html, body, div, h1, h2, h3, h4, h5, h6, p, img, dl,
  dt, dd, ol, ul, li, table, tr, td, form, object, embed,
  article, aside, canvas, command, details, fieldset,
  figcaption, figure, footer, group, header, hgroup, legend,
  mark, menu, meter, nav, output, progress, section, summary,
  time, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  }
  article, aside, details, figcaption, figure, footer,
  header, hgroup, menu, nav, section {
  display: block;
  }
  html {
  font: 81.25% arial, helvetica, sans-serif;
  background: #fff;
  color: #333;
  line-height: 1;
  direction: ltr;
  }
  a {
  color: #15c;
  text-decoration: none;
  }
  a:active {
  color: #d14836;
  }
  a:hover {
  text-decoration: underline;
  }
  h1, h2, h3, h4, h5, h6 {
  color: #222;
  font-size: 1.54em;
  font-weight: normal;
  line-height: 24px;
  margin: 0 0 .46em;
  }
  p {
  line-height: 17px;
  margin: 0 0 1em;
  }
  ol, ul {
  list-style: none;
  line-height: 17px;
  margin: 0 0 1em;
  }
  li {
  margin: 0 0 .5em;
  }
  table {
  border-collapse: collapse;
  border-spacing: 0;
  }
  strong {
  color: #222;
  }
</style>
<style type="text/css">
  html, body {
  position: absolute;
  height: 100%;
  min-width: 100%;
  }
  .wrapper {
  position: relative;
  min-height: 100%;
  }
  .wrapper + style + iframe {
  display: none;
  }
  .content {
  padding: 0 44px;
  }
  .topbar {
  text-align: right;
  padding-top: .5em;
  padding-bottom: .5em;
  }
  .Loogle-header-bar {
  height: 71px;
  background: #f1f1f1;
  border-bottom: 1px solid #e5e5e5;
  overflow: hidden;
  }
  .header .logo {
  margin: 17px 0 0;
  float: left;
  }
  .header .signin,
  .header .signup {
  margin: 28px 0 0;
  float: right;
  font-weight: bold;
  }
  .header .signin-button,
  .header .signup-button {
  margin: 22px 0 0;
  float: right;
  }
  .header .signin-button a {
  font-size: 13px;
  font-weight: normal;
  }
  .header .signup-button a {
  position: relative;
  top: -1px;
  margin: 0 0 0 1em;
  }
  .main {
  margin: 0 auto;
  width: 650px;
  padding-top: 23px;
  padding-bottom: 100px;
  }
  .main h1:first-child {
  margin: 0 0 .92em;
  }
  .Loogle-footer-bar {
  position: absolute;
  bottom: 0;
  height: 35px;
  width: 100%;
  border-top: 1px solid #ebebeb;
  overflow: hidden;
  }
  .footer {
  padding-top: 9px;
  font-size: .85em;
  white-space: nowrap;
  line-height: 0;
  }
  .footer ul {
  color: #999;
  float: left;
  max-width: 80%;
  }
  .footer ul li {
  display: inline;
  padding: 0 1.5em 0 0;
  }
  .footer a {
  color: #333;
  }
  .footer .lang-chooser-wrap {
  float: right;
  max-width: 20%;
  }
  .footer .lang-chooser-wrap img {
  vertical-align: middle;
  }
  .footer .attribution {
  float: right;
  }
  .footer .attribution span {
  vertical-align: text-top;
  }
  .redtext {
  color: #dd4b39;
  }
  .greytext {
  color: #555;
  }
  .secondary {
  font-size: 11px;
  color: #666;
  }
  .source {
  color: #093;
  }
  .hidden {
  display: none;
  }
  .announce-bar {
  position: absolute;
  bottom: 35px;
  height: 33px;
  z-index: 2;
  width: 100%;
  background: #f9edbe;
  border-top: 1px solid #efe1ac;
  border-bottom: 1px solid #efe1ac;
  overflow: hidden;
  }
  .announce-bar .message {
  font-size: .85em;
  line-height: 33px;
  margin: 0;
  }
  .announce-bar .message .separated {
  margin-left: 1.5em;
  }
  .announce-bar-ac {
  background: #eee;
  border-top: 1px solid #e5e5e5;
  border-bottom: 1px solid #e5e5e5;
  }
  .clearfix:after {
  visibility: hidden;
  display: block;
  font-size: 0;
  content: '.';
  clear: both;
  height: 0;
  }
  * html .clearfix {
  zoom: 1;
  }
  *:first-child+html .clearfix {
  zoom: 1;
  }
  pre {
  font-family: monospace;
  position: absolute;
  left: 0;
  margin: 0;
  padding: 1.5em;
  font-size: 13px;
  background: #f1f1f1;
  border-top: 1px solid #e5e5e5;
  direction: ltr;
  }
</style>
<style type="text/css">
  button, input, select, textarea {
  font-family: inherit;
  font-size: inherit;
  }
  button::-moz-focus-inner,
  input::-moz-focus-inner {
  border: 0;
  }
  input[type=email],
  input[type=number],
  input[type=password],
  input[type=tel],
  input[type=text],
  input[type=url] {
  -webkit-appearance: none;
  appearance: none;
  display: inline-block;
  height: 29px;
  margin: 0;
  padding: 0 8px;
  background: #fff;
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-border-radius: 1px;
  -moz-border-radius: 1px;
  border-radius: 1px;
  }
  input[type=email]:hover,
  input[type=number]:hover,
  input[type=password]:hover,
  input[type=tel]:hover,
  input[type=text]:hover,
  input[type=url]:hover {
  border: 1px solid #b9b9b9;
  border-top: 1px solid #a0a0a0;
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  }
  input[type=email]:focus,
  input[type=number]:focus,
  input[type=password]:focus,
  input[type=tel]:focus,
  input[type=text]:focus,
  input[type=url]:focus {
  outline: none;
  border: 1px solid #4d90fe;
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  }
  input[type=email][disabled=disabled],
  input[type=number][disabled=disabled],
  input[type=password][disabled=disabled],
  input[type=tel][disabled=disabled],
  input[type=text][disabled=disabled],
  input[type=url][disabled=disabled] {
  border: 1px solid #e5e5e5;
  background: #f1f1f1;
  }
  input[type=email][disabled=disabled]:hover,
  input[type=number][disabled=disabled]:hover,
  input[type=password][disabled=disabled]:hover,
  input[type=tel][disabled=disabled]:hover,
  input[type=text][disabled=disabled]:hover,
  input[type=url][disabled=disabled]:hover {
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
  }
  input[type=email][readonly=readonly],
  input[type=number][readonly=readonly],
  input[type=password][readonly=readonly],
  input[type=text][readonly=readonly],
  input[type=url][readonly=readonly] {
  border: 1px solid #d9d9d9;
  }
  input[type=email][readonly=readonly]:hover,
  input[type=number][readonly=readonly]:hover,
  input[type=password][readonly=readonly]:hover,
  input[type=text][readonly=readonly]:hover,
  input[type=url][readonly=readonly]:hover,
  input[type=email][readonly=readonly]:focus,
  input[type=number][readonly=readonly]:focus,
  input[type=password][readonly=readonly]:focus,
  input[type=text][readonly=readonly]:focus,
  input[type=url][readonly=readonly]:focus {
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
  }
  input[type=checkbox].form-error,
  input[type=email].form-error,
  input[type=number].form-error,
  input[type=password].form-error,
  input[type=text].form-error,
  input[type=tel].form-error,
  input[type=url].form-error {
  border: 1px solid #dd4b39;
  }
  input[type=checkbox],
  input[type=radio] {
  -webkit-appearance: none;
  appearance: none;
  width: 13px;
  height: 13px;
  margin: 0;
  cursor: pointer;
  vertical-align: bottom;
  background: #fff;
  border: 1px solid #dcdcdc;
  -webkit-border-radius: 1px;
  -moz-border-radius: 1px;
  border-radius: 1px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  position: relative;
  }
  input[type=checkbox]:active,
  input[type=radio]:active {
  border-color: #c6c6c6;
  background: #ebebeb;
  }
  input[type=checkbox]:hover {
  border-color: #c6c6c6;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);
  -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);
  }
  input[type=radio] {
  -webkit-border-radius: 1em;
  -moz-border-radius: 1em;
  border-radius: 1em;
  width: 15px;
  height: 15px;
  }
  input[type=checkbox]:checked,
  input[type=radio]:checked {
  background: #fff;
  }
  input[type=radio]:checked::after {
  content: '';
  display: block;
  position: relative;
  top: 3px;
  left: 3px;
  width: 7px;
  height: 7px;
  background: #666;
  -webkit-border-radius: 1em;
  -moz-border-radius: 1em;
  border-radius: 1em;
  }
  input[type=checkbox]:checked::after {
  content: url(//web.archive.org/web/20130608134259im_/https://ssl.gstatic.com/ui/v1/menu/checkmark.png);
  display: block;
  position: absolute;
  top: -6px;
  left: -5px;
  }
  input[type=checkbox]:focus {
  outline: none;
  border-color:#4d90fe;
  }
  .gaia-country-menu-item-flag, .gaia-country-menu-item-noflag {
  width: 16px;
  height: 11px;
  margin-right: 1em;
  }
  .gaia-country-menu-item-flag {
  background: no-repeat url(//web.archive.org/web/20130608134259im_/https://ssl.gstatic.com/i18n/phonenumbers/phoneinputwidget/flags4.png) 0 0;
  overflow: hidden;
  }
  .g-button {
  display: inline-block;
  min-width: 46px;
  text-align: center;
  color: #444;
  font-size: 11px;
  font-weight: bold;
  height: 27px;
  padding: 0 8px;
  line-height: 27px;
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  border-radius: 2px;
  -webkit-transition: all 0.218s;
  -moz-transition: all 0.218s;
  -ms-transition: all 0.218s;
  -o-transition: all 0.218s;
  transition: all 0.218s;
  border: 1px solid #dcdcdc;
  background-color: #f5f5f5;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#f1f1f1));
  background-image: -webkit-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: -moz-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: -ms-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: -o-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: linear-gradient(top,#f5f5f5,#f1f1f1);
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
  cursor: default;
  }
  *+html .g-button {
  min-width: 70px;
  }
  button.g-button,
  input[type=submit].g-button {
  height: 29px;
  line-height: 29px;
  vertical-align: bottom;
  margin: 0;
  }
  *+html button.g-button,
  *+html input[type=submit].g-button {
  overflow: visible;
  }
  .g-button:hover {
  border: 1px solid #c6c6c6;
  color: #333;
  text-decoration: none;
  -webkit-transition: all 0.0s;
  -moz-transition: all 0.0s;
  -ms-transition: all 0.0s;
  -o-transition: all 0.0s;
  transition: all 0.0s;
  background-color: #f8f8f8;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#f8f8f8),to(#f1f1f1));
  background-image: -webkit-linear-gradient(top,#f8f8f8,#f1f1f1);
  background-image: -moz-linear-gradient(top,#f8f8f8,#f1f1f1);
  background-image: -ms-linear-gradient(top,#f8f8f8,#f1f1f1);
  background-image: -o-linear-gradient(top,#f8f8f8,#f1f1f1);
  background-image: linear-gradient(top,#f8f8f8,#f1f1f1);
  -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
  -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
  }
  .g-button:active {
  background-color: #f6f6f6;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#f6f6f6),to(#f1f1f1));
  background-image: -webkit-linear-gradient(top,#f6f6f6,#f1f1f1);
  background-image: -moz-linear-gradient(top,#f6f6f6,#f1f1f1);
  background-image: -ms-linear-gradient(top,#f6f6f6,#f1f1f1);
  background-image: -o-linear-gradient(top,#f6f6f6,#f1f1f1);
  background-image: linear-gradient(top,#f6f6f6,#f1f1f1);
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  }
  .g-button:visited {
  color: #666;
  }
  .g-button-submit {
  border: 1px solid #3079ed;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1);
  background-color: #4d90fe;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#4d90fe),to(#4787ed));
  background-image: -webkit-linear-gradient(top,#4d90fe,#4787ed);
  background-image: -moz-linear-gradient(top,#4d90fe,#4787ed);
  background-image: -ms-linear-gradient(top,#4d90fe,#4787ed);
  background-image: -o-linear-gradient(top,#4d90fe,#4787ed);
  background-image: linear-gradient(top,#4d90fe,#4787ed);
  }
  .g-button-submit:hover {
  border: 1px solid #2f5bb7;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #357ae8;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#4d90fe),to(#357ae8));
  background-image: -webkit-linear-gradient(top,#4d90fe,#357ae8);
  background-image: -moz-linear-gradient(top,#4d90fe,#357ae8);
  background-image: -ms-linear-gradient(top,#4d90fe,#357ae8);
  background-image: -o-linear-gradient(top,#4d90fe,#357ae8);
  background-image: linear-gradient(top,#4d90fe,#357ae8);
  }
  .g-button-submit:active {
  background-color: #357ae8;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#4d90fe),to(#357ae8));
  background-image: -webkit-linear-gradient(top,#4d90fe,#357ae8);
  background-image: -moz-linear-gradient(top,#4d90fe,#357ae8);
  background-image: -ms-linear-gradient(top,#4d90fe,#357ae8);
  background-image: -o-linear-gradient(top,#4d90fe,#357ae8);
  background-image: linear-gradient(top,#4d90fe,#357ae8);
  -webkit-box-shadow: inset 0 1px 2px rgb	a(0,0,0,0.3);
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  }
  .g-button-share {
  border: 1px solid #29691d;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1);
  background-color: #3d9400;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#3d9400),to(#398a00));
  background-image: -webkit-linear-gradient(top,#3d9400,#398a00);
  background-image: -moz-linear-gradient(top,#3d9400,#398a00);
  background-image: -ms-linear-gradient(top,#3d9400,#398a00);
  background-image: -o-linear-gradient(top,#3d9400,#398a00);
  background-image: linear-gradient(top,#3d9400,#398a00);
  }
  .g-button-share:hover {
  border: 1px solid #2d6200;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #368200;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#3d9400),to(#368200));
  background-image: -webkit-linear-gradient(top,#3d9400,#368200);
  background-image: -moz-linear-gradient(top,#3d9400,#368200);
  background-image: -ms-linear-gradient(top,#3d9400,#368200);
  background-image: -o-linear-gradient(top,#3d9400,#368200);
  background-image: linear-gradient(top,#3d9400,#368200);
  }
  .g-button-share:active {
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  }
  .g-button-red {
  border: 1px solid transparent;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1);
  text-transform: uppercase;
  background-color: #d14836;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#dd4b39),to(#d14836));
  background-image: -webkit-linear-gradient(top,#dd4b39,#d14836);
  background-image: -moz-linear-gradient(top,#dd4b39,#d14836);
  background-image: -ms-linear-gradient(top,#dd4b39,#d14836);
  background-image: -o-linear-gradient(top,#dd4b39,#d14836);
  background-image: linear-gradient(top,#dd4b39,#d14836);
  }
  .g-button-red:hover {
  border: 1px solid #b0281a;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #c53727;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#dd4b39),to(#c53727));
  background-image: -webkit-linear-gradient(top,#dd4b39,#c53727);
  background-image: -moz-linear-gradient(top,#dd4b39,#c53727);
  background-image: -ms-linear-gradient(top,#dd4b39,#c53727);
  background-image: -o-linear-gradient(top,#dd4b39,#c53727);
  background-image: linear-gradient(top,#dd4b39,#c53727);
  -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.2);
  -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.2);
  -ms-box-shadow: 0 1px 1px rgba(0,0,0,0.2);
  -o-box-shadow: 0 1px 1px rgba(0,0,0,0.2);
  box-shadow: 0 1px 1px rgba(0,0,0,0.2);
  }
  .g-button-red:active {
  border: 1px solid #992a1b;
  background-color: #b0281a;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#dd4b39),to(#b0281a));
  background-image: -webkit-linear-gradient(top,#dd4b39,#b0281a);
  background-image: -moz-linear-gradient(top,#dd4b39,#b0281a);
  background-image: -ms-linear-gradient(top,#dd4b39,#b0281a);
  background-image: -o-linear-gradient(top,#dd4b39,#b0281a);
  background-image: linear-gradient(top,#dd4b39,#b0281a);
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  color: #fff
  }
  .g-button-white {
  border: 1px solid #dcdcdc;
  color: #666;
  background: #fff;
  }
  .g-button-white:hover {
  border: 1px solid #c6c6c6;
  color: #333;
  background: #fff;
  -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
  -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
  }
  .g-button-white:active {
  background: #fff;
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  }
  .g-button-red:visited,
  .g-button-share:visited,
  .g-button-submit:visited {
  color: #fff;
  }
  .g-button-submit:focus,
  .g-button-share:focus,
  .g-button-red:focus {
  -webkit-box-shadow: inset 0 0 0 1px #fff;
  -moz-box-shadow: inset 0 0 0 1px #fff;
  box-shadow: inset 0 0 0 1px #fff;
  }
  .g-button-share:focus {
  border-color: #29691d;
  }
  .g-button-red:focus {
  border-color: #d14836;
  }
  .g-button-submit:focus:hover,
  .g-button-share:focus:hover,
  .g-button-red:focus:hover {
  -webkit-box-shadow: inset 0 0 0 1px #fff, 0 1px 1px rgba(0,0,0,0.1);
  -moz-box-shadow: inset 0 0 0 1px #fff, 0 1px 1px rgba(0,0,0,0.1);
  box-shadow: inset 0 0 0 1px #fff, 0 1px 1px rgba(0,0,0,0.1);
  }
  .g-button.selected {
  background-color: #eee;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#eee),to(#e0e0e0));
  background-image: -webkit-linear-gradient(top,#eee,#e0e0e0);
  background-image: -moz-linear-gradient(top,#eee,#e0e0e0);
  background-image: -ms-linear-gradient(top,#eee,#e0e0e0);
  background-image: -o-linear-gradient(top,#eee,#e0e0e0);
  background-image: linear-gradient(top,#eee,#e0e0e0);
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  border: 1px solid #ccc;
  color: #333;
  }
  .g-button img {
  display: inline-block;
  margin: -3px 0 0;
  opacity: .55;
  filter: alpha(opacity=55);
  vertical-align: middle;
  pointer-events: none;
  }
  *+html .g-button img {
  margin: 4px 0 0;
  }
  .g-button:hover img {
  opacity: .72;
  filter: alpha(opacity=72);
  }
  .g-button:active img {
  opacity: 1;
  filter: alpha(opacity=100);
  }
  .g-button.disabled img {
  opacity: .5;
  filter: alpha(opacity=50);
  }
  .g-button.disabled,
  .g-button.disabled:hover,
  .g-button.disabled:active,
  .g-button-submit.disabled,
  .g-button-submit.disabled:hover,
  .g-button-submit.disabled:active,
  .g-button-share.disabled,
  .g-button-share.disabled:hover,
  .g-button-share.disabled:active,
  .g-button-red.disabled,
  .g-button-red.disabled:hover,
  .g-button-red.disabled:active,
  input[type=submit][disabled].g-button {
  background-color: none;
  opacity: .5;
  filter: alpha(opacity=50);
  cursor: default;
  pointer-events: none;
  }
  .goog-menu {
  -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  -moz-box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  -webkit-transition: opacity 0.218s;
  -moz-transition: opacity 0.218s;
  -ms-transition: opacity 0.218s;
  -o-transition: opacity 0.218s;
  transition: opacity 0.218s;
  background: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0,0,0,.2);
  cursor: default;
  font-size: 13px;
  margin: 0;
  outline: none;
  padding: 0 0 6px;
  position: absolute;
  z-index: 1000;
  overflow: auto;
  }
  .goog-menuitem,
  .goog-tristatemenuitem,
  .goog-filterobsmenuitem {
  position: relative;
  color: #333;
  cursor: pointer;
  list-style: none;
  margin: 0;
  padding: 6px 7em 6px 30px;
  white-space: nowrap;
  }
  .goog-menuitem-highlight,
  .goog-menuitem-hover {
  background-color: #eee;
  border-color: #eee;
  border-style: dotted;
  border-width: 1px 0;
  padding-top: 5px;
  padding-bottom: 5px;
  }
  .goog-menuitem-highlight .goog-menuitem-content,
  .goog-menuitem-hover .goog-menuitem-content {
  color: #333;
  }
  .goog-menuseparator {
  border-top: 1px solid #ebebeb;
  margin-top: 9px;
  margin-bottom: 10px;
  }
  .goog-inline-block {
  position: relative;
  display: -moz-inline-box;
  display: inline-block;
  }
  * html .goog-inline-block {
  display: inline;
  }
  *:first-child+html .goog-inline-block {
  display: inline;
  }
  .dropdown-block {
  display: block;
  }
  .goog-flat-menu-button {
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  border-radius: 2px;
  background-color: #f5f5f5;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#f1f1f1));
  background-image: -webkit-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: -moz-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: -ms-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: -o-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: linear-gradient(top,#f5f5f5,#f1f1f1);
  border: 1px solid #dcdcdc;
  color: #444;
  font-size: 11px;
  font-weight: bold;
  line-height: 27px;
  list-style: none;
  margin: 0 2px;
  min-width: 46px;
  outline: none;
  padding: 0 18px 0 6px;
  text-decoration: none;
  vertical-align: middle;
  }
  .goog-flat-menu-button-disabled {
  background-color: #fff;
  border-color: #f3f3f3;
  color: #b8b8b8;
  cursor: default;
  }
  .goog-flat-menu-button.goog-flat-menu-button-hover {
  background-color: #f8f8f8;
  background-image: -webkit-linear-gradient(top,#f8f8f8,#f1f1f1);
  background-image: -moz-linear-gradient(top,#f8f8f8,#f1f1f1);
  background-image: -ms-linear-gradient(top,#f8f8f8,#f1f1f1);
  background-image: -o-linear-gradient(top,#f8f8f8,#f1f1f1);
  background-image: linear-gradient(top,#f8f8f8,#f1f1f1);
  -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.1);
  -moz-box-shadow: 0 1px 1px rgba(0,0,0,.1);
  box-shadow: 0 1px 1px rgba(0,0,0,.1);
  border-color: #c6c6c6;
  color: #333;
  }
  .goog-flat-menu-button.goog-flat-menu-button-focused {
  border-color: #4d90fe;
  }
  .form-error .goog-flat-menu-button {
  border: 1px solid #dd4b39;
  }
  .form-error .goog-flat-menu-button-focused {
  border-color: #4d90fe;
  }
  .goog-flat-menu-button.goog-flat-menu-button-open,
  .goog-flat-menu-button.goog-flat-menu-button-active {
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
  background-color: #eee;
  background-image: -webkit-linear-gradient(top,#eee,#e0e0e0);
  background-image: -moz-linear-gradient(top,#eee,#e0e0e0);
  background-image: -ms-linear-gradient(top,#eee,#e0e0e0);
  background-image: -o-linear-gradient(top,#eee,#e0e0e0);
  background-image: linear-gradient(top,#eee,#e0e0e0);
  border: 1px solid #ccc;
  color: #333;
  z-index: 2;
  }
  .goog-flat-menu-button-caption {
  cursor: default;
  vertical-align: top;
  white-space: nowrap;
  }
  .goog-flat-menu-button-dropdown {
  border-color: #777 transparent;
  border-style: solid;
  border-width: 4px 4px 0;
  height: 0;
  width: 0;
  position: absolute;
  right: 5px;
  top: 12px;
  }
  .jfk-select .goog-flat-menu-button-dropdown {
  background: url(//web.archive.org/web/20130608134259im_/https://ssl.gstatic.com/ui/v1/disclosure/grey-disclosure-arrow-up-down.png) center no-repeat;
  border: none;
  height: 11px;
  margin-top: -4px;
  width: 7px;
  }
  .goog-menu-nocheckbox .goog-menuitem,
  .goog-menu-noicon .goog-menuitem {
  padding-left: 16px;
  vertical-align: middle;
  }
  body ::-webkit-scrollbar {
  height: 16px;
  width: 16px;
  overflow: visible;
  }
  body ::-webkit-scrollbar-button {
  height: 0;
  width: 0;
  }
  body ::-webkit-scrollbar-track {
  background-clip: padding-box;
  border: solid transparent;
  border-width: 0 0 0 7px;
  }
  body ::-webkit-scrollbar-track:horizontal {
  border-width: 7px 0 0;
  }
  body ::-webkit-scrollbar-track:hover {
  background-color: rgba(0,0,0,.05);
  -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.1);
  box-shadow: inset 1px 0 0 rgba(0,0,0,.1);
  }
  body ::-webkit-scrollbar-track:horizontal:hover {
  -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
  box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
  }
  body ::-webkit-scrollbar-track:active {
  background-color: rgba(0,0,0,.05);
  -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
  box-shadow: inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
  }
  body ::-webkit-scrollbar-track:horizontal:active {
  -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,.14),inset 0 -1px 0 rgba(0,0,0,.07);
  box-shadow: inset 0 1px 0 rgba(0,0,0,.14),inset 0 -1px 0 rgba(0,0,0,.07);
  }
  .jfk-scrollbar-dark::-webkit-scrollbar-track:hover {
  background-color: rgba(255,255,255,.1);
  -webkit-box-shadow: inset 1px 0 0 rgba(255,255,255,.2);
  box-shadow: inset 1px 0 0 rgba(255,255,255,.2);
  }
  .jfk-scrollbar-dark::-webkit-scrollbar-track:horizontal:hover {
  -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.2);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.2);
  }
  .jfk-scrollbar-dark::-webkit-scrollbar-track:active {
  background-color: rgba(255,255,255,.1);
  -webkit-box-shadow: inset 1px 0 0 rgba(255,255,255,.25),inset -1px 0 0 rgba(255,255,255,.15);
  box-shadow: inset 1px 0 0 rgba(255,255,255,.25),inset -1px 0 0 rgba(255,255,255,.15);
  }
  .jfk-scrollbar-dark::-webkit-scrollbar-track:horizontal:active {
  -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.25),inset 0 -1px 0 rgba(255,255,255,.15);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.25),inset 0 -1px 0 rgba(255,255,255,.15);
  }
  body ::-webkit-scrollbar-thumb {
  background-color: rgba(0,0,0,.2);
  background-clip: padding-box;
  border: solid transparent;
  border-width: 0 0 0 7px;
  min-height: 28px;
  padding: 100px 0 0;
  -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset 0 -1px 0 rgba(0,0,0,.07);
  box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset 0 -1px 0 rgba(0,0,0,.07);
  }
  body ::-webkit-scrollbar-thumb:horizontal {
  border-width: 7px 0 0;
  padding: 0 0 0 100px;
  -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset -1px 0 0 rgba(0,0,0,.07);
  box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset -1px 0 0 rgba(0,0,0,.07);
  }
  body ::-webkit-scrollbar-thumb:hover {
  background-color: rgba(0,0,0,.4);
  -webkit-box-shadow: inset 1px 1px 1px rgba(0,0,0,.25);
  box-shadow: inset 1px 1px 1px rgba(0,0,0,.25);
  }
  body ::-webkit-scrollbar-thumb:active {
  background-color: rgba(0,0,0,.5);
  -webkit-box-shadow: inset 1px 1px 3px rgba(0,0,0,.35);
  box-shadow: inset 1px 1px 3px rgba(0,0,0,.35);
  }
  .jfk-scrollbar-dark::-webkit-scrollbar-thumb {
  background-color: rgba(255,255,255,.3);
  -webkit-box-shadow: inset 1px 1px 0 rgba(255,255,255,.15),inset 0 -1px 0 rgba(255,255,255,.1);
  box-shadow: inset 1px 1px 0 rgba(255,255,255,.15),inset 0 -1px 0 rgba(255,255,255,.1);
  }
  .jfk-scrollbar-dark::-webkit-scrollbar-thumb:horizontal {
  -webkit-box-shadow: inset 1px 1px 0 rgba(255,255,255,.15),inset -1px 0 0 rgba(255,255,255,.1);
  box-shadow: inset 1px 1px 0 rgba(255,255,255,.15),inset -1px 0 0 rgba(255,255,255,.1);
  }
  .jfk-scrollbar-dark::-webkit-scrollbar-thumb:hover {
  background-color: rgba(255,255,255,.6);
  -webkit-box-shadow: inset 1px 1px 1px rgba(255,255,255,.37);
  box-shadow: inset 1px 1px 1px rgba(255,255,255,.37);
  }
  .jfk-scrollbar-dark::-webkit-scrollbar-thumb:active {
  background-color: rgba(255,255,255,.75);
  -webkit-box-shadow: inset 1px 1px 3px rgba(255,255,255,.5);
  box-shadow: inset 1px 1px 3px rgba(255,255,255,.5);
  }
  .jfk-scrollbar-borderless::-webkit-scrollbar-track {
  border-width: 0 1px 0 6px
  }
  .jfk-scrollbar-borderless::-webkit-scrollbar-track:horizontal {
  border-width: 6px 0 1px
  }
  .jfk-scrollbar-borderless::-webkit-scrollbar-track:hover {
  background-color: rgba(0,0,0,.035);
  -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.14),inset -1px -1px 0 rgba(0,0,0,.07);
  box-shadow: inset 1px 1px 0 rgba(0,0,0,.14),inset -1px -1px 0 rgba(0,0,0,.07);
  }
  .jfk-scrollbar-borderless.jfk-scrollbar-dark::-webkit-scrollbar-track:hover {
  background-color: rgba(255,255,255,.07);
  -webkit-box-shadow: inset 1px 1px 0 rgba(255,255,255,.25),inset -1px -1px 0 rgba(255,255,255,.15);
  box-shadow: inset 1px 1px 0 rgba(255,255,255,.25),inset -1px -1px 0 rgba(255,255,255,.15);
  }
  .jfk-scrollbar-borderless::-webkit-scrollbar-thumb {
  border-width: 0 1px 0 6px;
  }
  .jfk-scrollbar-borderless::-webkit-scrollbar-thumb:horizontal {
  border-width: 6px 0 1px;
  }
  body ::-webkit-scrollbar-corner {
  background: transparent;
  }
  body::-webkit-scrollbar-track-piece {
  background-clip: padding-box;
  background-color: #f1f1f1;
  border: solid #fff;
  border-width: 0 0 0 3px;
  -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
  box-shadow: inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
  }
  body::-webkit-scrollbar-track-piece:horizontal {
  border-width: 3px 0 0;
  -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,.14),inset 0 -1px 0 rgba(0,0,0,.07);
  box-shadow: inset 0 1px 0 rgba(0,0,0,.14),inset 0 -1px 0 rgba(0,0,0,.07);
  }
  body::-webkit-scrollbar-thumb {
  border-width: 1px 1px 1px 5px;
  }
  body::-webkit-scrollbar-thumb:horizontal {
  border-width: 5px 1px 1px;
  }
  body::-webkit-scrollbar-corner {
  background-clip: padding-box;
  background-color: #f1f1f1;
  border: solid #fff;
  border-width: 3px 0 0 3px;
  -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.14);
  box-shadow: inset 1px 1px 0 rgba(0,0,0,.14);
  }
  .jfk-scrollbar::-webkit-scrollbar {
  height: 16px;
  overflow: visible;
  width: 16px;
  }
  .jfk-scrollbar::-webkit-scrollbar-button {
  height: 0;
  width: 0;
  }
  .jfk-scrollbar::-webkit-scrollbar-track {
  background-clip: padding-box;
  border: solid transparent;
  border-width: 0 0 0 7px;
  }
  .jfk-scrollbar::-webkit-scrollbar-track:horizontal {
  border-width: 7px 0 0;
  }
  .jfk-scrollbar::-webkit-scrollbar-track:hover {
  background-color: rgba(0,0,0,.05);
  -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.1);
  box-shadow: inset 1px 0 0 rgba(0,0,0,.1);
  }
  .jfk-scrollbar::-webkit-scrollbar-track:horizontal:hover {
  -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
  box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
  }
  .jfk-scrollbar::-webkit-scrollbar-track:active {
  background-color: rgba(0,0,0,.05);
  -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
  box-shadow: inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
  }
  .jfk-scrollbar::-webkit-scrollbar-track:horizontal:active {
  -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,.14),inset 0 -1px 0 rgba(0,0,0,.07);
  box-shadow: inset 0 1px 0 rgba(0,0,0,.14),inset 0 -1px 0 rgba(0,0,0,.07);
  }
  .jfk-scrollbar-dark.jfk-scrollbar::-webkit-scrollbar-track:hover {
  background-color: rgba(255,255,255,.1);
  -webkit-box-shadow: inset 1px 0 0 rgba(255,255,255,.2);
  box-shadow: inset 1px 0 0 rgba(255,255,255,.2);
  }
  .jfk-scrollbar-dark.jfk-scrollbar::-webkit-scrollbar-track:horizontal:hover {
  -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.2);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.2);
  }
  .jfk-scrollbar-dark.jfk-scrollbar::-webkit-scrollbar-track:active {
  background-color: rgba(255,255,255,.1);
  -webkit-box-shadow: inset 1px 0 0 rgba(255,255,255,.25),inset -1px 0 0 rgba(255,255,255,.15);
  box-shadow: inset 1px 0 0 rgba(255,255,255,.25),inset -1px 0 0 rgba(255,255,255,.15);
  }
  .jfk-scrollbar-dark.jfk-scrollbar::-webkit-scrollbar-track:horizontal:active {
  -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.25),inset 0 -1px 0 rgba(255,255,255,.15);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.25),inset 0 -1px 0 rgba(255,255,255,.15);
  }
  .jfk-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(0,0,0,.2);
  background-clip: padding-box;
  border: solid transparent;
  border-width: 0 0 0 7px;
  min-height: 28px;
  padding: 100px 0 0;
  -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset 0 -1px 0 rgba(0,0,0,.07);
  box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset 0 -1px 0 rgba(0,0,0,.07);
  }
  .jfk-scrollbar::-webkit-scrollbar-thumb:horizontal {
  border-width: 7px 0 0;
  padding: 0 0 0 100px;
  -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset -1px 0 0 rgba(0,0,0,.07);
  box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset -1px 0 0 rgba(0,0,0,.07);
  }
  .jfk-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: rgba(0,0,0,.4);
  -webkit-box-shadow: inset 1px 1px 1px rgba(0,0,0,.25);
  box-shadow: inset 1px 1px 1px rgba(0,0,0,.25);
  }
  .jfk-scrollbar::-webkit-scrollbar-thumb:active {
  background-color: rgba(0,0,0,0.5);
  -webkit-box-shadow: inset 1px 1px 3px rgba(0,0,0,0.35);
  box-shadow: inset 1px 1px 3px rgba(0,0,0,0.35);
  }
  .jfk-scrollbar-dark.jfk-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(255,255,255,.3);
  -webkit-box-shadow: inset 1px 1px 0 rgba(255,255,255,.15),inset 0 -1px 0 rgba(255,255,255,.1);
  box-shadow: inset 1px 1px 0 rgba(255,255,255,.15),inset 0 -1px 0 rgba(255,255,255,.1);
  }
  .jfk-scrollbar-dark.jfk-scrollbar::-webkit-scrollbar-thumb:horizontal {
  -webkit-box-shadow: inset 1px 1px 0 rgba(255,255,255,.15),inset -1px 0 0 rgba(255,255,255,.1);
  box-shadow: inset 1px 1px 0 rgba(255,255,255,.15),inset -1px 0 0 rgba(255,255,255,.1);
  }
  .jfk-scrollbar-dark.jfk-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: rgba(255,255,255,.6);
  -webkit-box-shadow: inset 1px 1px 1px rgba(255,255,255,.37);
  box-shadow: inset 1px 1px 1px rgba(255,255,255,.37);
  }
  .jfk-scrollbar-dark.jfk-scrollbar::-webkit-scrollbar-thumb:active {
  background-color: rgba(255,255,255,.75);
  -webkit-box-shadow: inset 1px 1px 3px rgba(255,255,255,.5);
  box-shadow: inset 1px 1px 3px rgba(255,255,255,.5);
  }
  .jfk-scrollbar-borderless.jfk-scrollbar::-webkit-scrollbar-track {
  border-width: 0 1px 0 6px;
  }
  .jfk-scrollbar-borderless.jfk-scrollbar::-webkit-scrollbar-track:horizontal {
  border-width: 6px 0 1px;
  }
  .jfk-scrollbar-borderless.jfk-scrollbar::-webkit-scrollbar-track:hover {
  background-color: rgba(0,0,0,.035);
  -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.14),inset -1px -1px 0 rgba(0,0,0,.07);
  box-shadow: inset 1px 1px 0 rgba(0,0,0,.14),inset -1px -1px 0 rgba(0,0,0,.07);
  }
  .jfk-scrollbar-borderless.jfk-scrollbar-dark.jfk-scrollbar::-webkit-scrollbar-track:hover {
  background-color: rgba(255,255,255,.07);
  -webkit-box-shadow: inset 1px 1px 0 rgba(255,255,255,.25),inset -1px -1px 0 rgba(255,255,255,.15);
  box-shadow: inset 1px 1px 0 rgba(255,255,255,.25),inset -1px -1px 0 rgba(255,255,255,.15);
  }
  .jfk-scrollbar-borderless.jfk-scrollbar::-webkit-scrollbar-thumb {
  border-width: 0 1px 0 6px;
  }
  .jfk-scrollbar-borderless.jfk-scrollbar::-webkit-scrollbar-thumb:horizontal {
  border-width: 6px 0 1px;
  }
  .jfk-scrollbar::-webkit-scrollbar-corner {
  background: transparent;
  }
  body.jfk-scrollbar::-webkit-scrollbar-track-piece {
  background-clip: padding-box;
  background-color: #f1f1f1;
  border: solid #fff;
  border-width: 0 0 0 3px;
  -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
  box-shadow: inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
  }
  body.jfk-scrollbar::-webkit-scrollbar-track-piece:horizontal {
  border-width: 3px 0 0;
  -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,.14),inset 0 -1px 0 rgba(0,0,0,.07);
  box-shadow: inset 0 1px 0 rgba(0,0,0,.14),inset 0 -1px 0 rgba(0,0,0,.07);
  }
  body.jfk-scrollbar::-webkit-scrollbar-thumb {
  border-width: 1px 1px 1px 5px;
  }
  body.jfk-scrollbar::-webkit-scrollbar-thumb:horizontal {
  border-width: 5px 1px 1px;
  }
  body.jfk-scrollbar::-webkit-scrollbar-corner {
  background-clip: padding-box;
  background-color: #f1f1f1;
  border: solid #fff;
  border-width: 3px 0 0 3px;
  -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.14);
  box-shadow: inset 1px 1px 0 rgba(0,0,0,.14);
  }
  .errormsg {
  margin: .5em 0 0;
  display: block;
  color: #dd4b39;
  line-height: 17px;
  }
  .help-link {
  background: #dd4b39;
  padding: 0 5px;
  color: #fff;
  font-weight: bold;
  display: inline-block;
  -webkit-border-radius: 1em;
  -moz-border-radius: 1em;
  border-radius: 1em;
  text-decoration: none;
  position: relative;
  top: 0px;
  }
  .help-link:visited {
  color: #fff;
  }
  .help-link:hover {
  color: #fff;
  background: #c03523;
  text-decoration: none;
  }
  .help-link:active {
  opacity: 1;
  background: #ae2817;
  }
</style>
<style type="text/css">
  .jfk-butterBar {
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  -o-border-radius: 2px;
  border-radius: 2px;
  -webkit-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0px 2px 4px rgba(0,0,0,0.2);
  -o-box-shadow: 0px 2px 4px rgba(0,0,0,0.2);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  -webkit-transition: all 0 linear 1s, opacity 1s;
  -moz-transition: all 0 linear 1s, opacity 1s;
  -o-transition: all 0 linear 1s, opacity 1s;
  transition: all 0 linear 1s, opacity 1s;
  border-style: solid;
  border-width: 0;
  font-size: 11px;
  height: 0;
  opacity: 0;
  visibility: hidden;
  overflow: hidden;
  padding: 0;
  text-align: center;
  }
  .jfk-butterBar-warning {
  background-color: #dd4b39;
  border-color: #602019;
  color: #fff;
  }
  .jfk-butterBar-warning a {
  color: #fff;
  font-weight: bold;
  text-decoration: underline;
  }
  .jfk-butterBar-shown {
  -webkit-transition: opacity 0.218s;
  -moz-transition: opacity 0.218s;
  -o-transition: opacity 0.218s;
  transition: opacity 0.218s;
  border-width: 1px;
  height: 14px;
  opacity: 1;
  visibility: visible;
  padding: 6px 16px;
  }
  .signuponepage .jfk-butterBar {
  margin: -35px 0 7px;
  }
  .signuponepage .jfk-butterBar-warning a.cta {
  padding-left: .5em;
  }
  .signuponepage .jfk-butterBar-warning a.cta img {
  vertical-align: middle;
  }
  .signuponepage .sign-up {
  width: 362px;
  float: right;
  }
  .signuponepage .signup-box {
  margin: 0;
  padding: 25px;
  background: #f1f1f1;
  border: 1px solid #e5e5e5;
  }
  .signuponepage .side-content {
  margin: 0 420px 0 0;
  }
  .signuponepage .side-content .benefit {
  margin: 0 0 2.5em;
  overflow: hidden;
  }
  .signuponepage .side-content .benefit img:first-child {
  float: left;
  border: 1px solid #e5e5e5;
  }
  .signuponepage .side-content .benefit div {
  margin: 0 0 0 275px;
  }
  .signuponepage .side-content .benefit div h2 {
  color: #555;
  }
  .signuponepage .side-content .benefit div p {
  color: #999;
  line-height: 19px;
  }
  .signuponepage .side-content .benefit div p:last-child {
  margin: 0;
  }
  .signuponepage .why-information {
  margin: 1em 25px 0;
  color: #999;
  }
  .signuponepage input[type=text],
  .signuponepage input[type=password] {
  direction: ltr;
  }
  .signuponepage input[type=tel],
  .signuponepage input[type=text],
  .signuponepage input[type=password],
  .signuponepage select {
  width: 100%;
  }
  .signuponepage .form-element {
  position: relative;
  margin: 0 0 1.5em;
  }
  .signuponepage .form-element label {
  display: inline-block;
  width: 100%;
  position: relative;
  }
  .signuponepage .form-element strong {
  margin: 0 0 .5em;
  display: inline-block;
  width: 100%;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
  }
  .signuponepage .form-element.multi-field label strong {
  display: none;
  }
  .signuponepage .form-element .placeholder-text {
  position: absolute;
  top: 8px;
  left: 10px;
  color: #999;
  display: none;
  }
  .signuponepage .form-element.name label.firstname {
  width: 150px;
  margin-right: 5px;
  }
  .signuponepage .form-element.name label.lastname {
  width: 150px;
  }
  .signuponepage .form-element.name label.firstname input,
  .signuponepage .form-element.name label.lastname input {
  direction: ltr;
  }
  .signuponepage .form-element.name .placeholder-text {
  left: 10px;
  }
  .signuponepage .form-element.birthday label {
  margin-right: 5px;
  }
  .signuponepage .form-element.birthday label.year {
  width: 97px;
  margin-right: 0;
  }
  .signuponepage .form-element.birthday label.month {
  width: 135px;
  }
  .signuponepage .form-element.birthday label.day {
  width: 60px;
  }
  .signuponepage .form-element.email-address input {
  direction: ltr;
  }
  .signuponepage .form-element .atgmail {
  position: absolute;
  top: 27px;
  right: 10px;
  color: #999;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
  direction: ltr;
  }
  .signuponepage .username-suggestions {
  margin: .5em 0 0;
  color: #666;
  }
  .signuponepage .username-suggestions a {
  display: inline-block;
  cursor: pointer;
  margin-left: 1em;
  }
  .signuponepage .form-element.no-recovery-email label strong {
  color: #797979;
  }
  .signuponepage .form-element .set-homepage-explanation {
  margin-bottom: 20px;
  color: #797979;
  }
  .signuponepage .form-element.terms-of-service input[type=checkbox],
  .signuponepage .form-element.personalization input[type=checkbox],
  .signuponepage .form-element.skip-captcha input[type=checkbox],
  .signuponepage .form-element.recovery-email input[type=checkbox],
  .signuponepage .form-element.set-homepage input[type=checkbox] {
  float: left;
  margin: 2px 0 0;
  }
  .signuponepage .form-element.terms-of-service label strong,
  .signuponepage .form-element.personalization label strong,
  .signuponepage .form-element.skip-captcha label strong,
  .signuponepage .form-element.no-recovery-email label strong,
  .signuponepage .form-element.set-homepage label .set-homepage-explanation strong {
  font-weight: normal;
  line-height: 17px;
  display: block;
  margin: 0 0 0 28px;
  width: 282px;
  }
  .signuponepage .form-element.nextstep-button {
  text-align: right;
  margin: 0;
  }
  .signuponepage .terms-of-service .errormsg {
  margin-left: 28px;
  }
  .signuponepage .linkmsg {
  margin: 0.5em 0 0;
  }
  .signuponepage .infomsg {
  color: #797979;
  line-height: 17px;
  margin: 0.5em 0 0;
  display: none;
  }
  .jfk-bubble {
  -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.2);
  -moz-box-shadow: 0 1px 3px rgba(0,0,0,.2);
  box-shadow: 0 1px 3px rgba(0,0,0,.2);
  background-color: #fff;
  border: 1px solid;
  position: absolute;
  z-index: 1201 !important;
  border-color: #bbb #bbb #a8a8a8;
  padding: 16px;
  width: 255px;
  line-height: 17px;
  }
  .jfk-bubble-arrow {
  position: absolute
  }
  .jfk-bubble-arrow .jfk-bubble-arrowimplbefore,.jfk-bubble-arrow .jfk-bubble-arrowimplafter {
  display:block;
  height:0;
  position:absolute;
  width:0
  }
  .jfk-bubble-arrow .jfk-bubble-arrowimplbefore {
  border:9px solid
  }
  .jfk-bubble-arrow .jfk-bubble-arrowimplafter {
  border:8px solid
  }
  .jfk-bubble-arrowdown {
  bottom:0
  }
  .jfk-bubble-arrowup {
  top:-9px
  }
  .jfk-bubble-arrowleft {
  left:-9px
  }
  .jfk-bubble-arrowright {
  right:0
  }
  .jfk-bubble-arrowdown .jfk-bubble-arrowimplbefore,.jfk-bubble-arrowup .jfk-bubble-arrowimplbefore {
  border-color:#bbb transparent;
  left:-9px
  }
  .jfk-bubble-arrowdown .jfk-bubble-arrowimplbefore {
  border-color:#a8a8a8 transparent
  }
  .jfk-bubble-arrowdown .jfk-bubble-arrowimplafter,.jfk-bubble-arrowup .jfk-bubble-arrowimplafter {
  border-color:#fff transparent;
  left:-8px
  }
  .jfk-bubble-arrowdown .jfk-bubble-arrowimplbefore {
  border-bottom-width:0
  }
  .jfk-bubble-arrowdown .jfk-bubble-arrowimplafter {
  border-bottom-width:0
  }
  .jfk-bubble-arrowup .jfk-bubble-arrowimplbefore {
  border-top-width:0
  }
  .jfk-bubble-arrowup .jfk-bubble-arrowimplafter {
  border-top-width:0;
  top:1px
  }
  .jfk-bubble-arrowleft .jfk-bubble-arrowimplbefore,.jfk-bubble-arrowright .jfk-bubble-arrowimplbefore {
  border-color:transparent #bbb;
  top:-9px
  }
  .jfk-bubble-arrowleft .jfk-bubble-arrowimplafter,.jfk-bubble-arrowright .jfk-bubble-arrowimplafter {
  border-color:transparent #fff;
  top:-8px
  }
  .jfk-bubble-arrowleft .jfk-bubble-arrowimplbefore {
  border-left-width:0
  }
  .jfk-bubble-arrowleft .jfk-bubble-arrowimplafter {
  border-left-width:0;
  left:1px
  }
  .jfk-bubble-arrowright .jfk-bubble-arrowimplbefore {
  border-right-width:0
  }
  .jfk-bubble-arrowright .jfk-bubble-arrowimplafter {
  border-right-width:0
  }
  .jfk-bubble.jfk-bubble-promo {
  background-color:#f9edbe;
  border:1px solid #f0c36d
  }
  .jfk-bubble-promo .jfk-bubble-arrowdown .jfk-bubble-arrowimplbefore,.jfk-bubble-promo .jfk-bubble-arrowup .jfk-bubble-arrowimplbefore {
  border-color:#f0c36d transparent
  }
  .jfk-bubble-promo .jfk-bubble-arrowdown .jfk-bubble-arrowimplafter,.jfk-bubble-promo .jfk-bubble-arrowup .jfk-bubble-arrowimplafter {
  border-color:#f9edbe transparent
  }
  .jfk-bubble-promo .jfk-bubble-arrowleft .jfk-bubble-arrowimplbefore,.jfk-bubble-promo .jfk-bubble-arrowright .jfk-bubble-arrowimplbefore {
  border-color:transparent #f0c36d
  }
  .jfk-bubble-promo .jfk-bubble-arrowleft .jfk-bubble-arrowimplafter,.jfk-bubble-promo .jfk-bubble-arrowright .jfk-bubble-arrowimplafter {
  border-color:transparent #f9edbe
  }
  .password-strength p {
  margin: 0;
  }
  .password-strength .meter {
  margin: 4px 0;
  height: 5px;
  background: #f5f5f5;
  }
  .password-strength .meter #strength-bar {
  display: block;
  height: 100%;
  width: 0px;
  }
  .password-strength .meter .short {
  background: #a03;
  }
  .password-strength .meter .weak {
  background: #a03;
  }
  .password-strength .meter .fair {
  background: #fc3;
  }
  .password-strength .meter .good {
  background: #2d98f3;
  }
  .password-strength .meter .strong {
  background: #76c261;
  }
  .password-strength .meter .notRated {
  background: #666;
  }
  .talk_number_input {
  direction: ltr;
  margin: 0;
  width: 100%;
  color: #333;
  text-decoration: none;
  list-style: none;
  vertical-align: top;
  cursor: pointer;
  outline: none;
  -moz-outline: none;
  background-color: #fff;
  border-collapse: collapse;
  padding: 0;
  }
  .talk_number_input th {
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  border-right-width: 0;
  }
  .talk_number_input td {
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  border-left-width: 0;
  vertical-align: middle;
  }
  .talk_number_input input {
  border-width: 0;
  margin: 0;
  outline: none;
  }
  .talk_number_input-menu {
  padding: 0;
  outline: none;
  width: 40px;
  }
  .talk-select-country {
  padding: 8px 2px 0 5px;
  height: 21px;
  vertical-align: middle;
  outline: none;
  }
  .talk-select-country-dropdown {
  background: no-repeat url(//web.archive.org/web/20130608134259im_/https://ssl.gstatic.com/i18n/phonenumbers/phoneinputwidget/phone-input-arrow.png) center center;
  width: 10px;
  margin-left: 3px;
  }
  .talk-select-country-hover {
  background-color: #eee;
  }
  div.talk-select-country-menu {
  height: 208px;
  overflow-y: auto;
  overflow-x: hidden;
  }
  .talk-select-country-menu .goog-menuitem {
  white-space: nowrap;
  }
  span.talk-select-country-name {
  margin: 0 5px 0 7px;
  }
  span.talk-select-country-code {
  color: #666;
  }
  .talk-flag {
  background: no-repeat url(//web.archive.org/web/20130608134259im_/https://ssl.gstatic.com/i18n/phonenumbers/phoneinputwidget/flags4.png) 0 0;
  width: 16px;
  height: 11px;
  overflow: hidden;
  margin-left: 4px;
  }
  .talk-select-country-focused {
  background-color: #eee;
  }
  #BirthMonth .goog-flat-menu-button {
  width: 108px;
  margin: -3px 0 0 0;
  }
  #Gender .goog-flat-menu-button {
  width: 285px;
  margin: 0;
  }
  #CountryCode {
  position: relative;
  }
  #CountryCode .goog-menu {
  height: 200px;
  overflow: auto;
  top: 0 !important;
  z-index: 1202;
  }
  #CountryCode .goog-flat-menu-button {
  width: 285px;
  margin: 0;
  overflow: hidden;
  }
  #CountryCode .goog-flat-menu-button-caption {
  overflow: hidden;
  text-overflow: ellipsis;
  width: inherit;
  }
  #CountryCode .goog-menuitem,
  #CountryCode .goog-menuitem-rtl {
  overflow: auto;
  width: 285px;
  }
  .main {
  width: 950px;
  }
  .main h1 {
  margin: 0 0 .92em;
  }
</style>
<style type="text/css">
@media (max-width: 800px) {
  html {
  background: #f1f1f1;
  min-width: 100%;
  -webkit-tap-highlight-color: rgba(0,0,0,0);
  }
  h1, h2, h3, h4, h5, h6 {
  font-size: 1.4em;
  }
  .main {
  width: auto;
  max-width: 276px;
  padding-bottom: 85px;
  padding-top: 15px;
  overflow-x: hidden;
  }
  .content {
  padding-left: 22px;
  padding-right: 22px;
  }
  .header .signin-button {
  margin: 17px 0 0;
  }
  .side-content {
  display: none;
  }
  .signup-steps ol {
  display: none;
  }
  .goog-flat-menu-button-dropdown {
  background: url(//web.archive.org/web/20130608134259im_/https://ssl.gstatic.com/ui/v1/disclosure/grey-disclosure-arrow-up-down.png) center no-repeat;
  border: none;
  height: 11px;
  margin-top: 1px;
  width: 7px;
  }
  .signuponepage .sign-up {
  width: 100%;
  }
  .signuponepage .signup-box {
  margin: 0;
  padding: 0;
  background: #f1f1f1;
  border: none;
  }
  .signuponepage #BirthMonth .goog-flat-menu-button,
  .signuponepage #Gender .goog-flat-menu-button,
  .signuponepage #CountryCode .goog-flat-menu-button {
  width: 100%;
  -webkit-appearance: none;
  padding: 0;
  height: 37px;
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  border-radius: 2px;
  background-color: #f5f5f5;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#f1f1f1));
  background-image: -webkit-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: -moz-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: -ms-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: -o-linear-gradient(top,#f5f5f5,#f1f1f1);
  background-image: linear-gradient(top,#f5f5f5,#f1f1f1);
  border: 1px solid #dcdcdc;
  color: #444;
  font-size: 11px;
  font-weight: bold;
  line-height: 27px;
  list-style: none;
  margin: 0 2px;
  min-width: 46px;
  
  outline: none;
  }
  .signuponepage .goog-flat-menu-button .goog-flat-menu-button-caption,
  .signuponepage .goog-flat-menu-button .goog-flat-menu-button-dropdown {
  padding: 5px;
  }
  .signuponepage .talk-select-country {
  height: 24px;
  padding: 13px 2px 0 5px;
  }
  .signuponepage goog-flat-menu-button:focus {
  border: 1px solid #4d90fe;
  }
  .signuponepage goog-flat-menu-button.form-error {
  border: 1px solid rgb(221, 75, 57);
  }
  .signuponepage .form-element .placeholder-text {
  top: 11px;
  }
  .signuponepage .form-element.name label.firstname {
  width: 133px;
  }
  .signuponepage .form-element.name label.lastname {
  width: 134px;
  }
  .signuponepage .form-element.birthday label.year {
  width: 86px;
  }
  .signuponepage .form-element.birthday label.month {
  width: 107px;
  }
  .signuponepage .form-element.birthday label.day {
  width: 65px;
  }
  .signuponepage .form-element #GenderHolder {
  position: relative;
  }
  .signuponepage .form-element #RecoveryPhoneCountryHolder {
  position: relative;
  }
  .signuponepage .form-element #CountryCodeHolder {
  position: relative;
  }
  .signuponepage .form-element .atgmail {
  top: 30px;
  }
  .signuponepage .form-element.terms-of-service label strong,
  .signuponepage .form-element.personalization label strong,
  .signuponepage .form-element.skip-captcha label strong,
  .signuponepage .form-element.no-recovery-email label strong,
  .signuponepage .form-element.set-homepage label .set-homepage-explanation strong {
  width: 248px;
  }
  .signuponepage .form-element #submitbutton {
  width: 100%;
  }
  .signuponepage .infomsg {
  display: none;
  -webkit-transition: opacity 500ms ease-in-out;
  }
  .password-strength {
  margin-bottom: 10px;
  display: block;
  }
  .g-button {
  height: 35px;
  line-height: 35px;
  }
  input[type=email],
  input[type=number],
  input[type=password],
  input[type=tel],
  input[type=text],
  input[type=url],
  input[type=submit].g-button {
  height: 37px;
  }
  .recaptcha-widget#recaptcha_widget {
  width: 276px;
  }
  .recaptcha-widget #recaptcha_image {
  width: 266px !important;
  }
  .recaptcha-widget #recaptcha_image img {
  width: 100%;
  }
  .recaptcha-widget .recaptcha-main input[type=text] {
  width: 170px;
  }
  .recaptcha-widget .recaptcha-buttons {
  bottom: 20px;
  }
  .footer .lang-chooser-wrap {
  display: none;
  }
  .jfk-bubble {
  display: none;
  }
}
</style>
<style type="text/css">
  .recaptcha-widget#recaptcha_widget {
  width: 310px;
  background: #fff;
  border: 1px solid #e5e5e5;
  }
  .recaptcha-widget #recaptcha_image {
  padding: 5px;
  height: 57px;
  text-align: center;
  border-bottom: 1px solid #e5e5e5;
  overflow: hidden;
  }
  .recaptcha-widget #recaptcha_image a {
  line-height: 17px;
  }
  .recaptcha-widget .recaptcha-main {
  position: relative;
  padding: 13px;
  }
  .recaptcha-widget .recaptcha-main .errormsg {
  margin: 0 0 .5em;
  }
  .recaptcha-widget .recaptcha-main label strong {
  color: #222;
  display: block;
  margin: 0 0 .4em;
  }
  .recaptcha-widget .recaptcha-main input[type=text] {
  width: 200px;
  }
  .recaptcha-widget .recaptcha-buttons {
  position: absolute;
  bottom: 16px;
  right: 11px;
  }
  .recaptcha-widget .recaptcha-buttons a {
  display: inline-block;
  height: 21px;
  width: 21px;
  margin-left: 2px;
  background: #fff;
  background-position: center center;
  background-repeat: no-repeat;
  line-height: 0;
  opacity: .55;
  }
  .recaptcha-widget .recaptcha-buttons a:hover {
  opacity: .8;
  }
  .recaptcha-widget #recaptcha_reload_btn {
  background: url(//web.archive.org/web/20130608134259im_/https://ssl.gstatic.com/accounts/recaptcha-sprite.png) -63px;
  }
  .recaptcha-widget #recaptcha_switch_audio_btn {
  background: url(//web.archive.org/web/20130608134259im_/https://ssl.gstatic.com/accounts/recaptcha-sprite.png) -42px;
  }
  .recaptcha-widget #recaptcha_switch_img_btn {
  background: url(//web.archive.org/web/20130608134259im_/https://ssl.gstatic.com/accounts/recaptcha-sprite.png) -21px;
  }
  .recaptcha-widget #recaptcha_whatsthis_btn {
  background: url(//web.archive.org/web/20130608134259im_/https://ssl.gstatic.com/accounts/recaptcha-sprite.png);
  }
  .recaptcha-widget .recaptcha-buttons span {
  position: absolute;
  left: -99999em;
  }
  .recaptcha-widget.recaptcha_is_showing_audio .recaptcha_only_if_image,
  .recaptcha-widget.recaptcha_isnot_showing_audio .recaptcha_only_if_audio {
  display: none !important;
  }

  #country-code-form-element {
    display: none;
  }

  #termsofservice-form-element {
    display: none;
  }

  #birthday-form-element {
    display: none;
  }

  #gender-form-element {
    display: none;
  }

  #phone-form-element {
    display: none;
  }

  #recovery-email-form-element {
    display: none;
  }

  .personalization {
    display: none;
  }

  #recaptcha_widget {
    display: none;
  }


  .skip-captcha {
    display: none;
  }

  .linkmsg {
    display: none;
  }

  #confirm-password-label {
    display: none;
  }

  .atgmail {
    display: none;
  }

  #name-form-element {
    display: none;
  }

  .header .signin-button a {
    font-size: 13px;
    font-weight: bold;
    height: 32px;
  }

</style>
  <noscript>
  <style type="text/css">
  .signuponepage .infomsg {
  display: block;
  }
  </style>

  <style>


  </style>
  </noscript>

<div class="wrapper">

<div class="Loogle-header-bar">
  <div class="header content clearfix">
  <img class="logo" style="height: 50px" src="../assets/site_images/logo.png" alt="Loogle">
  <span class="signin-button">
  <a id="link-signin" class="g-button" href="login.php">Sign in</a>
  </span>
  </div>
  </div>
  
  <div class="signuponepage main content clearfix">
  <noscript>
  <div class="jfk-butterBar jfk-butterBar-warning jfk-butterBar-shown">
  <p>
  In order to sign up for a Loogle Account, you need to have <a target="_blank" href="#">JavaScript enabled</a> in your browser.
  <a class="cta" href="">
  <img src="//web.archive.org/web/20130606023031im_/https://ssl.gstatic.com/accounts/ui/refresh_white.png">
  Refresh this page after you have enabled JavaScript.
  </a>
  </p>
  </div>
  </noscript>
  <h1 class="redtext">Create a new Loogle Account</h1>
  <div class="clearfix">
  <div class="sign-up">
    <div class="signup-box">

<br>

        <form class="createaccount-form" id="createaccount" name="createaccount" action="register_form.php" method="post">
            
            <div class="form-element email-address" id="gmail-address-form-element">
                <label id="gmail-address-label">
                    <strong>Choose your username</strong>
                    <input type="text" maxlength="30" autocomplete="off" name="username" id="GmailAddress" value="" spellcheck="false" required>
                    <span class="atgmail">@gmail.com</span>
                </label>
            </div>

            
            <div class="form-element" id="password-form-element">
              <label id="password-label">
                  <strong>Create a password</strong>
                  <input type="password" name="password" id="Passwd" required pattern="[A-Za-z0-9]+" title="Password can only contain letters and numbers">
              </label>
            </div>

            
            <?php if (REQUIRE_CODE_FOR_REGISTRATION): ?>
                <div class="form-element" id="registration-code-form-element">
                    <label id="registration-code-label">
                        <strong>Enter your registration code</strong>
                        <input type="text" name="registration_code" id="RegistrationCode" required style="margin-bottom: 10px;">
                        <p class="instructions">
                            Need a code? Contact <a href="mailto:erievalleysoftware@gmail.com">erievalleysoftware@gmail.com</a> or join the 
                            <a href="https://discord.gg/ecvmxZMQf8" target="_blank">Discord Server</a> and DM an Admin (NCP3.0 is the owner).
                        </p>
                    </label>
                </div>
            <?php endif; ?>

            
            <div class="form-element nextstep-button">
                <input id="submitbutton" name="submitbutton" type="submit" value="Sign Up" class="g-button g-button-submit">
            </div>
        </form>
      
    </div>

  </div>



  <div class="side-content">
<div class="benefit">
  <img src="../assets/accounts/ui/more-than.jpg" alt="" width="245" height="244">
  <div>
  <h2>
  Your Loogle Account is more than just Search.
</h2>
  <p class="greytext">Talk, chat, share, schedule, store, organize, collaborate, discover, and create. Use Loogle products from Gmail to Loogle+ to LiveLeak (No Gore Allowed, Not Realted To THAT LiveLeak), view your search history, all with one username and password, all backed up all the time and easy to find at (you guessed it) Loogle.com.</p>
  </div>
</div>
<div class="benefit">
  <img src="../assets/accounts/ui/take-it-with-you.jpg" alt="" width="245" height="154">
  <div>
  <h2>Take it all with you.</h2>
  <p class="greytext">A Loogle Account lets you access all your stuff — Gmail, photos, and more — from any device. Search by taking pictures, or by voice. Get free turn-by-turn navigation, upload your pictures automatically, and even buy things with your phone using Loogle Wallet.</p>
  </div>
</div>
<div class="benefit">
  <img src="../assets/accounts/ui/share.jpg" alt="" width="245" height="154">
  <div>
  <h2>Share a little. Or share a lot.</h2>
  <p class="greytext">Share selectively with friends, family (maybe even your boss) on Loogle+. Start a video call with friends, send a message to a group all at once, or just follow posts from people who fascinate you. Your call.</p>
  </div>
</div>
<div class="benefit">
  <img src="../assets/accounts/ui/work-in-the-future.jpg" alt="" width="245" height="154">
  <div>
  <h2>Work in the future.</h2>
  <p class="greytext">Get a jump on the next era of doing, well, everything. Watch as colleagues or partners drop in a photo, update a spreadsheet, or improve a paragraph, in real-time, from 1,000 miles away. Loogle Docs is free with a Loogle Account.</p>
  </div>
</div>
</div>
</div>



  </div>
  <div class="Loogle-footer-bar">
  <div class="footer content clearfix">
  <ul id="footer-list">

      <li>© 2025 Loogle</li>
      <li><a href="terms_of_service.php" target="_blank">Terms of Service</a></li>
      <li><a href="privacy_policy.php" target="_blank">Privacy Policy</a></li>
      <li><a href="https://github.com/erievs/loogle-plus-2025">Github</a></li>
      <li><b>DO NOT USE REAL PASSWORDS, THIS IS NOT AN OFFICAL loogle OR ALPHABET PROJECT</b></li>

  </div>
</div>

<script>

    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    $(document).ready(function() {  
      
        var errorMessage = getQueryParam('error');

        if (errorMessage) {
          alert(errorMessage);
        }
    });
</script>