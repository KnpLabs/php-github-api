<?php
namespace ArgoCD\Tests\Api;

use ArgoCD\Api\ApplicationService;

class ApplicationServiceTest extends TestCase
{
    protected function getApiClass(): string
    {
        return ApplicationService::class;
    }

    // --- Test Cases for list ---
    public function testListApplications(): void
    {
        $expectedResponse = ['items' => []];
        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo('/api/v1/applications'), $this->equalTo([]))
            ->will($this->returnValue($expectedResponse));

        $result = $api->list();
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testListApplicationsWithParams(): void
    {
        $expectedResponse = ['items' => [['metadata' => ['name' => 'app1']]]];
        $queryParams = ['selector' => 'env=prod', 'projects' => ['proj1', 'proj2']];
        
        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo('/api/v1/applications'), $this->equalTo($queryParams))
            ->will($this->returnValue($expectedResponse));

        $result = $api->list($queryParams);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    // --- Test Cases for create ---
    public function testCreateApplication(): void
    {
        $appData = ['metadata' => ['name' => 'new-app'], 'spec' => ['project' => 'default']];
        $expectedResponse = ['metadata' => ['name' => 'new-app'], 'spec' => ['project' => 'default']];

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('/api/v1/applications'),
                $this->equalTo($appData)
            )
            ->will($this->returnValue($expectedResponse));

        $result = $api->create($appData);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testCreateApplicationWithUpsertAndValidate(): void
    {
        $appData = ['metadata' => ['name' => 'new-app-upsert'], 'spec' => ['project' => 'default']];
        $expectedResponse = $appData;
        $upsert = true;
        $validate = true;
        // Note: http_build_query sorts params by name, so validate=true comes before upsert=true
        $expectedPath = '/api/v1/applications?validate=true&upsert=true';


        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo($expectedPath),
                $this->equalTo($appData)
            )
            ->will($this->returnValue($expectedResponse));

        $result = $api->create($appData, $upsert, $validate);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }
    
    public function testCreateApplicationWithUpsertOnly(): void
    {
        $appData = ['metadata' => ['name' => 'new-app-upsert-only'], 'spec' => ['project' => 'default']];
        $expectedResponse = $appData;
        $upsert = true;
        $validate = null; 
        $expectedPath = '/api/v1/applications?upsert=true';

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo($expectedPath),
                $this->equalTo($appData)
            )
            ->will($this->returnValue($expectedResponse));

        $result = $api->create($appData, $upsert, $validate);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }


    // --- Test Cases for get ---
    public function testGetApplication(): void
    {
        $appName = 'test-app';
        $expectedResponse = ['metadata' => ['name' => $appName]];
        $expectedPath = sprintf('/api/v1/applications/%s', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo($expectedPath), $this->equalTo([]))
            ->will($this->returnValue($expectedResponse));

        $result = $api->get($appName);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testGetApplicationWithParams(): void
    {
        $appName = 'test-app-params';
        $queryParams = ['refresh' => 'hard', 'project' => ['proj-A']];
        $expectedResponse = ['metadata' => ['name' => $appName]];
        $expectedPath = sprintf('/api/v1/applications/%s', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo($expectedPath), $this->equalTo($queryParams))
            ->will($this->returnValue($expectedResponse));

        $result = $api->get($appName, $queryParams);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    // --- Test Cases for update ---
    public function testUpdateApplication(): void
    {
        $appName = 'app-to-update';
        $appData = ['spec' => ['description' => 'new description']];
        $expectedResponse = ['metadata' => ['name' => $appName], 'spec' => $appData['spec']];
        $expectedPath = sprintf('/api/v1/applications/%s', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo($expectedPath), // Path without query params
                $this->equalTo($appData)
            )
            ->will($this->returnValue($expectedResponse));

        $result = $api->update($appName, $appData);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testUpdateApplicationWithValidateAndProject(): void
    {
        $appName = 'app-to-update-complex';
        $appData = ['spec' => ['description' => 'another description']];
        $expectedResponse = $appData;
        $validate = true;
        $project = 'my-special-project';
        // http_build_query sorts params, project comes before validate
        $expectedPath = sprintf('/api/v1/applications/%s?project=%s&validate=true', rawurlencode($appName), rawurlencode($project));


        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo($expectedPath),
                $this->equalTo($appData)
            )
            ->will($this->returnValue($expectedResponse));

        $result = $api->update($appName, $appData, $validate, $project);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    // --- Test Cases for delete ---
    public function testDeleteApplication(): void
    {
        $appName = 'app-to-delete';
        $expectedResponse = []; // Delete often returns empty or minimal response
        $expectedPath = sprintf('/api/v1/applications/%s', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with($this->equalTo($expectedPath), $this->equalTo([]))
            ->will($this->returnValue($expectedResponse));

        $result = $api->delete($appName);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testDeleteApplicationWithParams(): void
    {
        $appName = 'app-to-delete-cascade';
        $queryParams = ['cascade' => 'true', 'propagationPolicy' => 'foreground']; // Note: bools as strings
        $expectedResponse = [];
        $expectedPath = sprintf('/api/v1/applications/%s', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with($this->equalTo($expectedPath), $this->equalTo($queryParams))
            ->will($this->returnValue($expectedResponse));

        $result = $api->delete($appName, $queryParams);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    // --- Test Cases for sync ---
    public function testSyncApplication(): void
    {
        $appName = 'app-to-sync';
        $syncData = ['revision' => 'HEAD', 'prune' => true];
        $expectedResponse = ['status' => 'Sync initiated'];
        $expectedPath = sprintf('/api/v1/applications/%s/sync', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with($this->equalTo($expectedPath), $this->equalTo($syncData))
            ->will($this->returnValue($expectedResponse));

        $result = $api->sync($appName, $syncData);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    // --- Test Cases for rollback ---
    public function testRollbackApplication(): void
    {
        $appName = 'app-to-rollback';
        $rollbackData = ['id' => 123, 'prune' => false, 'dryRun' => true];
        $expectedResponse = ['status' => 'Rollback initiated'];
        $expectedPath = sprintf('/api/v1/applications/%s/rollback', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with($this->equalTo($expectedPath), $this->equalTo($rollbackData))
            ->will($this->returnValue($expectedResponse));

        $result = $api->rollback($appName, $rollbackData);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    // --- Test Cases for managedResources ---
    public function testManagedResources(): void
    {
        $appName = 'app-managed';
        $expectedResponse = ['items' => [['kind' => 'Pod', 'name' => 'p1']]];
        $expectedPath = sprintf('/api/v1/applications/%s/managed-resources', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo($expectedPath), $this->equalTo([]))
            ->will($this->returnValue($expectedResponse));

        $result = $api->managedResources($appName);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testManagedResourcesWithParams(): void
    {
        $appName = 'app-managed-params';
        $queryParams = ['namespace' => 'ns1', 'kind' => 'Service'];
        $expectedResponse = ['items' => [['kind' => 'Service', 'name' => 's1']]];
        $expectedPath = sprintf('/api/v1/applications/%s/managed-resources', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo($expectedPath), $this->equalTo($queryParams))
            ->will($this->returnValue($expectedResponse));

        $result = $api->managedResources($appName, $queryParams);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    // --- Test Cases for resourceTree ---
    public function testResourceTree(): void
    {
        $appName = 'app-tree';
        $expectedResponse = ['nodes' => [['kind' => 'Application']]];
        $expectedPath = sprintf('/api/v1/applications/%s/resource-tree', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo($expectedPath), $this->equalTo([]))
            ->will($this->returnValue($expectedResponse));

        $result = $api->resourceTree($appName);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testResourceTreeWithParams(): void
    {
        $appName = 'app-tree-params';
        $queryParams = ['namespace' => 'default', 'group' => 'apps', 'kind' => 'Deployment'];
        $expectedResponse = ['nodes' => [['kind' => 'Deployment']]];
        $expectedPath = sprintf('/api/v1/applications/%s/resource-tree', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo($expectedPath), $this->equalTo($queryParams))
            ->will($this->returnValue($expectedResponse));

        $result = $api->resourceTree($appName, $queryParams);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    // --- Test Cases for getManifests ---
    public function testGetManifests(): void
    {
        $appName = 'app-manifests';
        $expectedResponse = ['manifests' => ["---apiVersion: v1...", "---apiVersion: apps/v1..."]];
        $expectedPath = sprintf('/api/v1/applications/%s/manifests', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo($expectedPath), $this->equalTo([]))
            ->will($this->returnValue($expectedResponse));

        $result = $api->getManifests($appName);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }

    public function testGetManifestsWithParams(): void
    {
        $appName = 'app-manifests-params';
        $queryParams = ['revision' => 'my-branch', 'sourcePositions' => 'true'];
        $expectedResponse = ['manifests' => ["---apiVersion: v1..."]];
        $expectedPath = sprintf('/api/v1/applications/%s/manifests', rawurlencode($appName));

        /** @var ApplicationService $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with($this->equalTo($expectedPath), $this->equalTo($queryParams))
            ->will($this->returnValue($expectedResponse));

        $result = $api->getManifests($appName, $queryParams);
        self::assertIsArray($result);
        self::assertEquals($expectedResponse, $result);
    }
}
