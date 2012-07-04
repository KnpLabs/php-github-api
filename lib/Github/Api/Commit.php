<?php

namespace Github\Api;

/**
 * Getting information on specific commits,
 * the diffs they introduce, the files they've changed.
 *
 * @link   http://developer.github.com/v3/repos/commits/
 * @author Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Commit extends Api
{
    /**
     * List commits by username, repo and branch
     * @link http://developer.github.com/v3/repos/commits/
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
     * @link http://developer.github.com/v3/repos/commits/
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
     * @link http://developer.github.com/v3/repos/commits/#get-a-single-commit
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $sha              the commit sha
     * @return  array                     data from commit
     */
    public function getCommit($username, $repo, $sha)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/commits/'.urlencode($sha));
    }

    /**
     * Fetch branch sha from branch name
     * @link http://developer.github.com/v3/git/refs/#get-a-reference
     *
     * @param string $username
     * @param string $repoName
     * @param string $branchName
     * @return null|string
     */
    private function getBranchSha($username, $repoName, $branchName)
    {
        $info = $this->get('repos/'.urlencode($username).'/'.urlencode($repoName).'/git/refs/'.urlencode($branchName));

        if (!isset($info['ref'])) {
            return null;
        }

        return $info['object']['sha'];
    }
}
