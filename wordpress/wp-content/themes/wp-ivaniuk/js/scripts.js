"use strict";!function(){for(var o,n=function(){},e=["assert","clear","count","debug","dir","dirxml","error","exception","group","groupCollapsed","groupEnd","info","log","markTimeline","profile","profileEnd","table","time","timeEnd","timeline","timelineEnd","timeStamp","trace","warn"],a=e.length,t=window.console=window.console||{};a--;)t[o=e[a]]||(t[o]=n)}(),"undefined"==typeof jQuery?console.warn("jQuery hasn't loaded"):console.log("jQuery "+jQuery.fn.jquery+" has loaded"),function(n){n("#preloader").fadeOut(),n(window).on("scroll",function(){100<n(window).scrollTop()?n(".header-top-area").addClass("menu-bg"):n(".header-top-area").removeClass("menu-bg")});function o(){n(window).width()<=768?n(".navbar-collapse a").on("click",function(){n(".navbar-collapse").collapse("hide")}):n(".navbar .navbar-inverse a").off("click")}n(window).scroll(function(){200<n(this).scrollTop()?n(".back-to-top").fadeIn(400):n(".back-to-top").fadeOut(400)}),n(".back-to-top").on("click",function(o){return o.preventDefault(),n("html, body").animate({scrollTop:0},600),!1}),n(window).on("load",function(){n("body").scrollspy({target:".navbar-collapse",offset:195}),n(window).on("scroll",function(){100<n(window).scrollTop()?n(".fixed-top").addClass("menu-bg"):n(".fixed-top").removeClass("menu-bg")})}),o(),n(window).resize(o)}(jQuery),$(document).ready(function(){$("a").on("click",function(o){if(""!==this.hash){o.preventDefault();var n=this.hash;$("html, body").animate({scrollTop:$(n).offset().top},800,function(){window.location.hash=n})}})});