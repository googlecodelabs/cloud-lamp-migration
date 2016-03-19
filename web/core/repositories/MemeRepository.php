<?php
require_once('BaseRepository.php');

class MemeRepository extends BaseRepository
{
	private $memeRepository;
	
	function __construct($option)
	{
		parent::__construct($option);
		$this->memeRepository = $this->mapper->meme;
	}

	public function getAll($userId = '', $approved = null, $order = 'new', $searchTerm = '', $page = null, $pageSize = 10)
	{
		$query = "select 
					meme.id as meme_id,
					meme.top_text,
					meme.bottom_text,
					meme.url_src_img,
					meme.url_final_img,
					meme.created_at,
					meme.gallery_id,
					user.id as user_id, 
					(SELECT COUNT(*) FROM votes WHERE votes.meme_id = meme.id AND votes.vote = 1 ) as upvote, 
					(SELECT COUNT(*) FROM votes WHERE votes.meme_id = meme.id AND votes.vote = -1) as downvote,
					(SELECT votes.vote FROM votes WHERE votes.meme_id = meme.id AND votes.user_id = :user) as user_vote,
					user.name as user_name,
					meme.is_approved
				from meme
				left join user 
					on user.id = meme.user_id
				left join votes 
					on meme.id = votes.meme_id
				";

		if ($approved != null) {
			$query = $query . " where meme.is_approved = :approved";
			if($searchTerm != ''){
				$query = $query . " and (top_text like :searchTerm || bottom_text like :searchTerm)";
			}
		} else if($searchTerm != ''){
			$query = $query . " where (top_text like :searchTerm || bottom_text like :searchTerm)";
		}

		$query = $query . " group by meme.id";

		switch ($order) {
			default:
		    case "new":
		        $query = $query." order by meme.created_at desc";
		        break;
		    case "most_voted":
		        $query = $query." order by upvote desc";
		        break;
		    case "most_downvoted":
		        $query = $query." order by downvote desc";
		        break;
		}

		if ($page != null) {
			$query = $query." limit :offset, :pageSize";
		}

		$dbQuery = parent::getConn()->prepare($query);
		if ($approved != null) {
			$dbQuery->bindParam(':approved',$approved,PDO::PARAM_BOOL);
		}
		$dbQuery->bindParam(':user',$userId,PDO::PARAM_STR);
		$dbQuery->bindParam(':user',$userId,PDO::PARAM_STR);

		if($searchTerm != '') {
			$like = '%'.$searchTerm.'%';
			$dbQuery->bindParam(':searchTerm',$like,PDO::PARAM_STR);
		}

		if ($page != null) {
			$offset = $pageSize * $page;
			$dbQuery->bindParam(':offset',$offset,PDO::PARAM_INT);
			$dbQuery->bindParam(':pageSize',$pageSize,PDO::PARAM_INT);
		}
		$dbQuery->execute();
		return $dbQuery->fetchAll();
	}

	public function getMeme($memeId)
	{
		return $this->memeRepository[$memeId]->fetch();
	}

	public function getAllFromUser($userId)
	{
		return $this->memeRepository($this->mapper->user, array("user_id" => $userId))->fetchAll();
	}

	public function save($meme)
	{
		$this->memeRepository->persist($meme);
		$this->mapper->flush();
	}

	public function removeMemeById($id)
	{
		$meme = $this->memeRepository[$id]->fetch();
		$this->memeRepository->remove($meme);
		$this->mapper->flush();
	}

	public function removeMeme($meme)
	{
		$this->memeRepository->remove($meme);
		$this->mapper->flush();
	}
}