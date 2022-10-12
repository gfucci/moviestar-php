<?php

    require_once("models/Review.php");
    require_once("models/Message.php");

    class ReviewDAO implements ReviewDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {

            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildReview($data) {

            $objectReview = new Review();

            $objectReview->id = $data["id"];
            $objectReview->rating = $data["rating"];
            $objectReview->review = $data["review"];
            $objectReview->users_id = $data["users_id"];
            $objectReview->movies_id = $data["movies_id"];

            return $objectReview;
        }

        public function create(Review $review) {


        }

        public function getMoviesReview($id) {


        }

        public function hasAlreadyReviewed($id, $userId) {


        }

        public function getRatings($id) {


        }

    }