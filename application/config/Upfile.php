<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* 上传配置信息 start */
$config['upload']                  = array();
$config['upload']['upload_path']   = 'public/images/upload/';//临时上传目录
$config['upload']['allowed_types'] = array("gif", "jpg", "jpeg", "png");//允许文件格式
$config['upload']['max_size']      = 2*1024*1024;//最大文件限制
$config['upload']['img_max']       = 4;//图片数量限制




$config['uploadVideos']                  = array();
$config['uploadVideos']['upload_path']   = 'public/videos/upload/';//临时上传目录
$config['uploadVideos']['allowed_types'] = array( '.flv' , '.wmv' , '.rmvb' ,'mp3','mp4');//允许文件格式
$config['uploadVideos']['max_size']      = 2*1024*1024*1024;//最大文件限制
/* 上传配置信息 end */