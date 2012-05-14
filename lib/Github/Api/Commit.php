<?php

namespace Github\Api;

/**
 * Getting information on specific commits,
 * the diffs they introduce, the files they've changed.
 *
 * @link      http://develop.github.com/p/commits.html
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class Commit extends Api
{
    /**
     * List commits by username, repo and branch
     * http://developer.github.com/v3/repos/commits/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $branch           the branch
     * @return  array                     list of users found
     */
    public function getBranchCommits($username, $repo, $branch)
    {
        $branchSha = $this->getBranchSha($username, $repo, $branch);

        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/commits?sha='.urlencode($branchSha));
    }

    /**
     * List commits by username, repo, branch and path
     * http://developer.github.com/v3/repos/commits/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $branch           the branch
     * @param   string  $path             the path
     * @return  array                     list of users found
     */
    public function getFileCommits($username, $repo, $branch, $path)
    {
        $branchSha = $this->getBranchSha($username, $repo, $branch);

        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/commits?path='.urlencode($path).'&sha='.urlencode($branchSha));
    }

    /**
     * Show a specific commit
     * http://developer.github.com/v3/repos/commits/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $sha              the commit sha
     */
    public function getCommit($username, $repo, $sha)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/commits/'.urlencode($sha));
    }

    /**
     * Fetch branch sha from branch name
     *
     * @param string $username
     * @param string $repoName
     * @param string $branchName
     * @return string
     */
    private function getBranchSha($username, $repoName, $branchName)
    {
        $branchInfo = $this->get('repos/'.urlencode($username).'/'.urlencode($repoName).'/git/trees/'.urlencode($branchName));
        if (isset($branchInfo['sha'])) {
            return $branchInfo['sha'];
        }
    }
}
