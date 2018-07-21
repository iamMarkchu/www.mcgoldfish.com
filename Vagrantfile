# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "homestead_502"
  config.vm.hostname = "mark-dev-2"
  config.vm.network "forwarded_port", guest: 80, host: 8888,id: 'nginx'
  config.vm.network "forwarded_port", guest: 6379, host: 6380,id: 'redis'
  config.vm.network "forwarded_port", guest: 3306, host: 3307,id: 'mysql'
  config.vm.network "forwarded_port", guest: 8000, host: 8001,id: 'nginx'
  config.vm.network "private_network", ip: "192.168.33.11",auto_config: true

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "2048"
    vb.cpus = 2
    vb.name = "mark-dev-2"
  end

end