<?php

namespace Github\Tests\Api\Enterprise;

use Github\Tests\Api\TestCase;

class ManagementConsoleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowConfigData()
    {
        $expectedJson = '{ "status": "running", "progress": [ { "status": "DONE", "key": "Appliance core components" },
        { "status": "DONE", "key": "GitHub utilities" }, { "status": "DONE", "key": "GitHub applications" },
        { "status": "CONFIGURING", "key": "GitHub services" }, { "status": "PENDING", "key":
        "Reloading appliance services" } ] }';
        $expectedArray = json_decode($expectedJson, true);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/setup/api/configcheck', ['license_md5' => $this->getLicenseHash()])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->configcheck($this->getLicenseHash()));
    }

    /**
     * @test
     */
    public function shouldShowSettingsData()
    {
        $expectedJson = '{ "enterprise": { "private_mode": false, "github_hostname": "ghe.local", "auth_mode":
        "default", "storage_mode": "rootfs", "admin_password": null, "configuration_id": 1401777404,
        "configuration_run_count": 4, "package_version": "11.10.332", "avatar": { "enabled": false, "uri": "" },
        "customer": { "name": "GitHub", "email": "stannis@themannis.biz", "uuid":
        "af6cac80-e4e1-012e-d822-1231380e52e9",
        "secret_key_data": "-----BEGIN PGP PRIVATE KEY BLOCK-----\nVersion: GnuPG v1.4.10 (GNU/Linux)\n\nlQcYBE5TCgsBEACk4yHpUcapplebaumBMXYMiLF+nCQ0lxpx...\n-----END PGP PRIVATE KEY BLOCK-----\n",
        "public_key_data": "-----BEGIN PGP PUBLIC KEY BLOCK-----\nVersion: GnuPG v1.4.10 (GNU/Linux)\n\nmI0ETqzZYgEEALSe6snowdenXyqvLfSQ34HWD6C7....\n-----END PGP PUBLIC KEY BLOCK-----\n" },
        "license": { "seats": 0, "evaluation": false, "expire_at": "2015-04-27T00:00:00-07:00", "perpetual": false,
        "unlimited_seating": true, "support_key": "ssh-rsa AAAAB3N....", "ssh_allowed": true }, "github_ssl":
        { "enabled": false, "cert": null, "key": null }, "ldap": { "host": "", "port": "", "base": [ ], "uid": "",
        "bind_dn": "", "password": "", "method": "Plain", "user_groups": [ ], "admin_group": "" }, "cas": { "url": "" },
        "github_oauth": { "client_id": "12313412", "client_secret": "kj123131132", "organization_name":
        "Homestar Runners", "organization_team": "homestarrunners/owners" }, "smtp": { "enabled": true, "address":
        "smtp.example.com", "authentication": "plain", "port": "1234", "domain": "blah", "username": "foo", "user_name":
        "mr_foo", "enable_starttls_auto": true, "password": "bar", "support_address": "enterprise@github.com",
        "noreply_address": "noreply@github.com" }, "dns": { "primary_nameserver": "8.8.8.8", "secondary_nameserver":
        "8.8.4.4" }, "ntp": { "primary_server": "0.ubuntu.pool.ntp.org", "secondary_server": "1.ubuntu.pool.ntp.org" },
        "timezone": { "identifier": "UTC" }, "device": { "path": "/dev/xyz" }, "snmp": { "enabled": false,
        "community": "" }, "rsyslog": { "enabled": false, "server": "", "protocol_name": "TCP" }, "assets": { "storage":
         "file", "bucket": null, "host_name": null, "key_id": null, "access_key": null }, "pages": { "enabled": true },
         "collectd": { "enabled": false, "server": "", "port": "", "encryption": "", "username": "foo", "password":
         "bar" } }, "run_list": [ "role[configure]" ] }';
        $expectedArray = json_decode($expectedJson, true);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/setup/api/settings', ['license_md5' => $this->getLicenseHash()])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->settings($this->getLicenseHash()));
    }

    /**
     * @test
     */
    public function shouldShowMaintenanceStatus()
    {
        $expectedJson = '{ "status": "scheduled", "scheduled_time": "Tuesday, January 22 at 15 => 34 -0800",
        "connection_services": [ { "name": "git operations", "number": 0 }, { "name": "mysql queries", "number": 233 },
        { "name": "resque jobs", "number": 54 } ] }';
        $expectedArray = json_decode($expectedJson, true);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/setup/api/maintenance', ['license_md5' => $this->getLicenseHash()])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->maintenance($this->getLicenseHash()));
    }

    /**
     * @test
     */
    public function shouldShowAuthorizedKeys()
    {
        $expectedJson = '[ { "key": "ssh-rsa AAAAB3NzaC1yc2EAAAAB...", "pretty-print":
        "ssh-rsa 01:14:0f:f2:0f:e2:fe:e8:f4:72:62:af:75:f7:1a:88:3e:04:92:64" },
        { "key": "ssh-rsa AAAAB3NzaC1yc2EAAAAB...", "pretty-print":
        "ssh-rsa 01:14:0f:f2:0f:e2:fe:e8:f4:72:62:af:75:f7:1a:88:3e:04:92:64" } ]';
        $expectedArray = json_decode($expectedJson, true);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/setup/api/settings/authorized-keys', ['license_md5' => $this->getLicenseHash()])
            ->will($this->returnValue($expectedArray));
        $this->assertEquals($expectedArray, $api->keys($this->getLicenseHash()));
    }

    protected function getLicenseHash()
    {
        return '1234567890abcdefghijklmnopqrstuv';
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Enterprise\ManagementConsole::class;
    }
}
