<?php
use \Httpful\Request;

class Item extends Page  {
    private $qid, $pagetype;

    function __construct($qid) {
        parent::__construct();
        $this->fullurl = sprintf("%s/%s", $this->root, $qid);
        $this->qid = $qid;
        $this->wditem = new WikidataItem($this->qid, $this->lang);
        $this->item = $this->wditem->getItemData();

        if (property_exists($this->item->sitelinks, $this->lang)) {
            $title = $this->item->sitelinks->{$this->lang}->title;
            $article = new WikipediaArticle($title, $this->lang);
            $this->article = $article->getArticleData();
        }

        $this->pagetype = $this->lookupPageType();
    }

    public function getPageType() {
        return $this->pagetype;
    }

    private function lookupPageType() {
        if ($this->wditem->hasClaimWhere(Items::$work)) {
            $this->wditem->addValues(Properties::$work);

            return "work";
        }

        if ($this->wditem->hasClaimWhere(Items::$creator)) {
            $this->wditem->addValues(Properties::$creator);

            $query = new WikidataQuery(sprintf(
                "CLAIM[%s:%s] AND CLAIM[%s]",
                substr(Properties::CREATOR, 1),
                $this->qid,
                substr(Properties::IMAGE, 1)
            ), $this->lang);

            $this->item->works = $query->getResultData();

            return "creator";
        }

        if ($this->wditem->getClaim(Properties::COMMONS_INSTITUTION_PAGE)) {
            $this->wditem->addValues(Properties::$institution);

            $query = new WikidataQuery(sprintf(
                "CLAIM[%s:%s] OR CLAIM[%s:%s] AND CLAIM[%s]",
                substr(Properties::COLLECTION, 1), $this->qid,
                substr(Properties::LOCATEDIN, 1), $this->qid,
                substr(Properties::IMAGE, 1)
            ), $this->lang);

            $this->item->works = $query->getResultData();

            return "institution";
        }

        return "article";
    }
}