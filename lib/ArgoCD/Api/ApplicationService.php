<?php
namespace ArgoCD\Api;

class ApplicationService extends AbstractApi
{
    /**
     * Corresponds to ApplicationService_List
     * Lists applications.
     *
     * @param array $queryParameters Optional query parameters:
     *        - name (string): the application's name.
     *        - refresh (string): forces application refresh (values: "hard", "normal", "false").
     *        - projects (array<string>): filter by project.
     *        - resourceVersion (string): resource version for watch.
     *        - selector (string): label selector for applications.
     *        - repo (string): repository URL.
     *        - appNamespace (string): application namespace.
     *        - project (array<string>): legacy, use `projects`.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function list(array $queryParameters = []): array
    {
        return $this->get('/api/v1/applications', $queryParameters);
    }

    /**
     * Corresponds to ApplicationService_Create
     * Creates a new application.
     *
     * @param array $applicationData Associative array representing the v1alpha1Application schema.
     * @param bool|null $upsert Whether to create in upsert mode.
     * @param bool|null $validate Whether to validate the application.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function create(array $applicationData, ?bool $upsert = null, ?bool $validate = null): array
    {
        $queryParams = [];
        if ($upsert !== null) {
            $queryParams['upsert'] = $upsert ? 'true' : 'false';
        }
        if ($validate !== null) {
            $queryParams['validate'] = $validate ? 'true' : 'false';
        }
        $queryString = '';
        if (!empty($queryParams)) {
            $queryString = '?' . http_build_query($queryParams);
        }
        return $this->post('/api/v1/applications' . $queryString, $applicationData);
    }

    /**
     * Corresponds to ApplicationService_Get
     * Gets a specific application.
     *
     * @param string $name The name of the application.
     * @param array $queryParameters Optional query parameters:
     *        - refresh (string): forces application refresh.
     *        - projects (array<string>): filter by project.
     *        - resourceVersion (string): resource version for watch.
     *        - selector (string): label selector.
     *        - repo (string): repository URL.
     *        - appNamespace (string): application namespace.
     *        - project (array<string>): legacy, use `projects`.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function get(string $name, array $queryParameters = []): array
    {
        $path = sprintf('/api/v1/applications/%s', rawurlencode($name));
        return $this->get($path, $queryParameters);
    }

    /**
     * Corresponds to ApplicationService_Update
     * Updates an application.
     *
     * @param string $applicationName The name of the application to update.
     * @param array $applicationData Associative array representing the v1alpha1Application schema.
     * @param bool|null $validate Whether to validate the application.
     * @param string|null $project Project of the application.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function update(string $applicationName, array $applicationData, ?bool $validate = null, ?string $project = null): array
    {
        $queryParams = [];
        if ($validate !== null) {
            $queryParams['validate'] = $validate ? 'true' : 'false';
        }
        if ($project !== null) {
            $queryParams['project'] = $project;
        }
        $queryString = '';
        if (!empty($queryParams)) {
            $queryString = '?' . http_build_query($queryParams);
        }
        $path = sprintf('/api/v1/applications/%s', rawurlencode($applicationName));
        return $this->put($path . $queryString, $applicationData);
    }
    
    /**
     * Corresponds to ApplicationService_Delete
     * Deletes an application.
     *
     * @param string $name The name of the application.
     * @param array $queryParameters Optional query parameters:
     *        - cascade (bool): whether to delete associated resources.
     *        - propagationPolicy (string): propagation policy for deletion.
     *        - appNamespace (string): application namespace.
     *        - project (string): project name.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function delete(string $name, array $queryParameters = []): array
    {
        $path = sprintf('/api/v1/applications/%s', rawurlencode($name));
        return $this->delete($path, $queryParameters);
    }

    /**
     * Corresponds to ApplicationService_Sync
     * Syncs an application to its target state.
     *
     * @param string $name The name of the application.
     * @param array $syncRequestData Associative array representing the applicationApplicationSyncRequest schema.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function sync(string $name, array $syncRequestData): array
    {
        $path = sprintf('/api/v1/applications/%s/sync', rawurlencode($name));
        return $this->post($path, $syncRequestData);
    }

    /**
     * Corresponds to ApplicationService_Rollback
     * Rolls back an application to a previous deployed version.
     *
     * @param string $name The name of the application.
     * @param array $rollbackRequestData Associative array representing the applicationApplicationRollbackRequest schema.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function rollback(string $name, array $rollbackRequestData): array
    {
        $path = sprintf('/api/v1/applications/%s/rollback', rawurlencode($name));
        return $this->post($path, $rollbackRequestData);
    }

    /**
     * Corresponds to ApplicationService_ManagedResources
     * Lists resources managed by the application.
     *
     * @param string $applicationName The name of the application.
     * @param array $queryParameters Optional query parameters:
     *        - namespace (string): resource namespace.
     *        - name (string): resource name.
     *        - version (string): resource version.
     *        - group (string): resource group.
     *        - kind (string): resource kind.
     *        - appNamespace (string): application namespace.
     *        - project (string): project name.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function managedResources(string $applicationName, array $queryParameters = []): array
    {
        $path = sprintf('/api/v1/applications/%s/managed-resources', rawurlencode($applicationName));
        return $this->get($path, $queryParameters);
    }

    /**
     * Corresponds to ApplicationService_ResourceTree
     * Gets the resource tree of an application.
     *
     * @param string $applicationName The name of the application.
     * @param array $queryParameters Optional query parameters:
     *        - namespace (string): resource namespace.
     *        - name (string): resource name.
     *        - version (string): resource version.
     *        - group (string): resource group.
     *        - kind (string): resource kind.
     *        - appNamespace (string): application namespace.
     *        - project (string): project name.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function resourceTree(string $applicationName, array $queryParameters = []): array
    {
        $path = sprintf('/api/v1/applications/%s/resource-tree', rawurlencode($applicationName));
        return $this->get($path, $queryParameters);
    }

    /**
     * Corresponds to ApplicationService_GetManifests
     * Gets the manifests of an application.
     *
     * @param string $name The name of the application.
     * @param array $queryParameters Optional query parameters:
     *        - revision (string): application revision.
     *        - appNamespace (string): application namespace.
     *        - project (string): project name.
     *        - sourcePositions (bool): include source positions in manifests.
     *        - revisions (array<string>): revisions to get manifests for.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function getManifests(string $name, array $queryParameters = []): array
    {
        $path = sprintf('/api/v1/applications/%s/manifests', rawurlencode($name));
        return $this->get($path, $queryParameters);
    }
}
