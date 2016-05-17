#!/bin/sh
#必要ツールのセットアップ
#debconf install
if [ ! -f /usr/games/sl ];then
	echo "debconfのインスト＾る"
	#sudo apt-get update
	sudo apt-get install -y  locales debconf-utils
	sudo apt-get install -y sl net-tools
	echo "debconfのインストール完了"
	sleep 1
else
	echo "debconfのインストールは完了しています"
	sleep 1
fi
#apache2 install
apache=/usr/sbin/apache2
if [ ! -f ${apache} ];then
	#apache install
	echo "apacheをインストールします"
	sudo aptitude install -y apache2
else
	echo "apacheのインストールは完了しています"
	sleep 1
fi
#git install
git=/usr/bin/git
if [ ! -f ${git} ];then
	sudo apt-get install -y git
else
	echo "gitのインストールは完了しています"
fi
#プログラムの配置
dir=/var/www/html/Dfun
if [ ! -d ${dir} ];then
	#ディレクトリを作成
	echo "ディレクトリを作成します"
	mkdir -p ${dir}
	cd ${dir}
	sleep 1;
else
	echo "ディレクトリの配置が完了しています。"
	sleep 1;
fi


#git pull or clone
echo "git pullを開始します"
cd ${dir}
sudo git init
sudo git checkout master
sudo git pull "https://github.com/Soft4-PBL1D/login.git"
#sudo git clone "https://github.com/Soft4-PBL1D/login.git"
sudo chmod a+x ${dir}/shell/yesterday.sh

#php5 mysql-server installs
php=/usr/bin/php5
if [ ! -f ${php} ];then
	#php5 insatll and mysql-server
	echo "php5をインストールします"
	#sudo sh -c " echo mysql-server-5.5 mysql-server/root_password password root" | debconf-set-selections
	#echo "mysql-server-5.5 mysql-server/root_password_again password root" | debconf-set-selections
	sudo apt-get install -y php5
	echo "php5のインストール完了"
	sleep 1
else
	echo "php5のインストールは完了しています"
	sleep 1
fi

#mysql-serverのインストール
mysql=/usr/bin/mysql
if [ ! -f ${mysql} ];then
	#sudo debconf-set-selections < ${dir}/shell/mysql-server.txt
	#sudo apt-get install -y mysql-server
	sudo sh -c "echo mysql-server-5.5 mysql-server/root_password password root | debconf-set-selections"
	sudo sh -c "echo mysql-server-5.5 mysql-server/root_password_again password root | debconf-set-selections"
	sudo apt-get -y install mysql-server-5.5
	echo "mysqlのインストール完了"
	sleep 1
else
	echo "mysql-serverのインストールは完了しています"
	sleep 1
fi

#sudo crontab -l > ${dir}/crontab
echo "59 23 * * ${dir}/shell/yesterday.sh" > ${dir}/crontab
sudo sh -c "cat ${dir}/crontab >> /etc/crontab"
mysql -u root -proot < ${dir}/Sql/Users.text
