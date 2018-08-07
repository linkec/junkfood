# hlsp2p-php-tracker
## Only Suitable For V0.1.x
       Just A SIMPLE Tracker!(Test Use Only)
       Just A SIMPLE Tracker!(Test Use Only)
       Just A SIMPLE Tracker!(Test Use Only)
       No performance guarantee!

       a tracker for HLSjs-p2p-engine written by PHP
       1.Install Nginx+PHP enviroment,whatever you are using Windows OR Linux(Better)
       2.Set the Nginx rewrite rule 

```C
location / { 
       try_files $uri $uri/ /?$args; 
}
```
       3.Enjoy

       BTW Apache is able to serve this file, but I am not sure how to write rewrite rule,Any one help us to improve?

       基于PHP编写的 HLSjs-p2p-engine Tracker
       1.安装Nginx和PHP环境 <br>
       2.设置Nginx的伪静态 <br>
```C
location / { 
       try_files $uri $uri/ /?$args; 
}
```
       完事儿~
