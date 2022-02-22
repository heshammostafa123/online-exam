-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2022 at 01:10 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_adb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `checklecturerexisting` (IN `lname` VARCHAR(255), IN `lpassword` VARCHAR(255))  BEGIN
	select 
		* 
    from 
		lecturer
	where username=lname
    and password=lpassword;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkstudentexisting` (IN `stname` VARCHAR(255), IN `stpassword` VARCHAR(255))  BEGIN
	select 
		* 
    from 
		student
	where username=stname
    and password=stpassword;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `courseupdate` (IN `doid` INT(11), IN `stid` INT(11), IN `coname` VARCHAR(255), IN `coid` INT(11))  BEGIN
	update 
											courses 
                                        set 
											D_id=doid,
                                            s_id=stid,
                                            course_name=coname
										 where 
										 	id=coid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteonecourse` (IN `coid` INT(11))  BEGIN
delete from courses where id=coid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteonestudent` (IN `stid` INT(11))  BEGIN
delete from student where id=stid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletequestiondependonid` (IN `qn` INT(11), IN `cid` INT(11))  BEGIN
delete from exam where question_number=qn and C_id=cid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletequestiondependonidcid` (IN `qn` INT(11), IN `cid` INT(11))  BEGIN
delete from exam where question_number=qn and C_id=cid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getallcourses` (IN `stid` INT(11))  BEGIN
	select * from courses where s_id=stid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getquestions` (IN `coursenum` INT(11), IN `questionnum` INT(11))  BEGIN
	select 
		* 
    from 
		exam
	where
		c_id=coursenum
	and
		question_number=questionnum;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_correct_answer` (IN `qnumber` INT(11), IN `cid` INT(11))  BEGIN
	select * from exam where question_number=qnumber and C_id=cid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertcourse` (IN `doid` INT(11), IN `stid` INT(11), IN `coursename` VARCHAR(255))  BEGIN
insert into courses(D_id,S_id,course_name) values(doid,stid,coursename);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertquestion` (IN `q_n` INT(11), IN `qbody` VARCHAR(255), IN `q_a1` VARCHAR(255), IN `q_a2` VARCHAR(255), IN `q_a3` VARCHAR(255), IN `tr_a` VARCHAR(255), IN `c_n` INT(11))  BEGIN
		insert into
			exam(question_number,q_body,q_answer1,q_answer2,q_answer3,true_answer,C_id)
			values(q_n,qbody,q_a1,q_a2,q_a3,tr_a,c_n);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertstudent` (IN `stname` VARCHAR(255), IN `stpassword` VARCHAR(255))  BEGIN
    insert into student(username,password) values(stname, stpassword) limit 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_score` (IN `cnumber` INT(11), IN `stid` INT(11), IN `stscore` INT(11))  BEGIN
	insert 
		into
	score(c_id,s_id,total)
		values(cnumber,stid,stscore);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_procedure` (IN `doid` INT(11), IN `stid` INT(11), IN `coname` VARCHAR(255), IN `coid` INT(11))  BEGIN
	update 
											courses 
                                        set 
											D_id=doid,
                                            s_id=stid,
                                            course_name=coname
										 where 
										 	id=coid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `numberofquestions` (IN `course_num` INT(11))  BEGIN
	select
		* 
	from 
		exam 
	where C_id=course_num;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `questionupdate` (IN `q_n` INT(11), IN `qbody` VARCHAR(255), IN `q_a1` VARCHAR(255), IN `q_a2` VARCHAR(255), IN `q_a3` VARCHAR(255), IN `tr_a` VARCHAR(255), IN `c_n` INT(11))  BEGIN
	update 
		exam 
	set 
		q_body=qbody ,
		q_answer1=q_a1,
		q_answer2=q_a2,
		q_answer3=q_a3,
		true_answer=tr_a,
		C_id=c_n
	 where 
		 question_number =q_n 
		and 
		C_id=c_n;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectacoursewithid` (IN `coid` INT(11))  BEGIN
select * from courses where id=coid limit 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectallcourses` ()  BEGIN
	select 	*	from courses order by id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectalldoctors` ()  BEGIN
select
	    								*
	    							from 
										lecturer
                                    order by
                                        id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectallquestions` ()  BEGIN
select
	    								*
	    							from 
										exam
                                    order by
                                        question_number ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectallstudents` ()  BEGIN
	select
	    								*
	    							from 
										student
                                    order by
                                        id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectallstudentswithjoin` ()  BEGIN
	SELECT score.total as total,student.id as id,student.username as username,courses.course_name as course_name
								from score
								INNER JOIN student
								on student.id=score.S_id
								INNER JOIN courses 
								ON courses.id =score.C_id
								order by 
                                    student.id desc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectmincourseid` (IN `cid` INT(11))  BEGIN
select MIN(question_number) from exam where 	C_id=cid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectquestiondependonid` (IN `qid` INT(11))  BEGIN
select * from exam where 	question_number =qid limit 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectquestiondependonqidcid` (IN `qid` INT(11), IN `cid` INT(11))  BEGIN
select * from exam where 	question_number =qid and C_id =cid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectquestionsbycourseid` (IN `cid` INT(11))  BEGIN
select * from exam where 	C_id=cid  order by question_number;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectstudentwithid` (IN `stid` INT(11))  BEGIN
	select * from student where id=stid limit 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `studentcourses` (IN `studentid` INT(11))  NO SQL
SELECT * from courses where s_id=studentid and status=0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `studentupdate` (IN `stname` VARCHAR(255), IN `stpassword` VARCHAR(255), IN `stid` INT(255))  BEGIN
	update 
		student 
	 set 
		username=stname ,
		password=stpassword,
        id=stid
	 where 
		id=stid ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `studentupdatestatus` (IN `stid` INT(255), IN `ststatus` INT(11))  BEGIN
	update 
		student 
	 set 
		status=ststatus
	 where 
		id=stid ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatestatus` (IN `studentid` INT(11), IN `courseid` INT(11))  NO SQL
update courses
	set status=1
	where s_id=studentid and id=courseid$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewcoursescores` (IN `coid` INT(11))  BEGIN
SELECT score.total as total,student.id as id,student.username as username,courses.course_name as course_name
								from score
								INNER JOIN student
								on student.id=score.S_id
								INNER JOIN courses 
								ON courses.id =score.C_id
                                where courses.id=coid
								order by 
                                    student.id desc;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `checklecturerexisting` (`lname` VARCHAR(255), `lpassword` VARCHAR(255)) RETURNS INT(11) BEGIN
DECLARE _count int(11);
SELECT COUNT(*) INTO _count FROM lecturer WHERE lecturer.username LIKE lname and lecturer.password LIKE lpassword ;
 RETURN (_count);
 END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `checkstudentexisting` (`sname` VARCHAR(255), `spassword` VARCHAR(255)) RETURNS INT(11) BEGIN
DECLARE _count int(11);
SELECT COUNT(*) INTO _count FROM student WHERE student.username LIKE sname and student.password LIKE spassword ;
 RETURN (_count);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `totalnumberofquestions` (`coursenum` INT(11)) RETURNS INT(11) BEGIN
	DECLARE total int(11);
    select count(question_number) into total
    from exam
    where exam.C_id like coursenum;
RETURN (total);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `D_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `D_id`, `s_id`, `course_name`, `status`) VALUES
(18, 1, 26, 'Advanced database', 0),
(19, 1, 27, 'WEB', 0),
(20, 1, 26, 'php', 0);

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `question_number` int(11) NOT NULL,
  `q_body` text NOT NULL,
  `q_answer1` varchar(255) NOT NULL,
  `q_answer2` varchar(255) NOT NULL,
  `q_answer3` varchar(255) NOT NULL,
  `true_answer` varchar(255) NOT NULL,
  `C_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`question_number`, `q_body`, `q_answer1`, `q_answer2`, `q_answer3`, `true_answer`, `C_id`) VALUES
(3, 'Which SQL statement is used to delete data from a database?', 'DELETE', 'COLLAPSE', 'remove', 'DELETE', 18),
(4, 'Which SQL statement is used to insert new data in a database?', 'ADD RECORD', 'INSERT NEW', 'INSERT INTO', 'INSERT INTO', 18),
(3, 'How to write an IF statement in JavaScript?', 'if i = 5 then', 'if i = 5', 'if (i == 5)', 'if (i == 5)', 19),
(4, 'How to write an IF statement for executing some code if ', 'if i <> 5', 'if (i != 5)', 'if i =! 5 then', 'if (i != 5)', 19),
(2, 'What is the most common type of join?', 'INNER JOIN', 'INSIDE JOIN', 'JOINED TABLE', 'INNER JOIN', 18),
(2, 'How do you find the number with the highest value of x and y?', 'Math.max(x, y)', 'top(x, y)', 'Math.ceil(x, y)', 'Math.max(x, y)', 19),
(3, 'All variables in PHP start with which symbol?', '&', '!', '$', '$', 20),
(4, 'The PHP syntax is most similar to:', 'VBScript', 'Perl and C', 'JavaScript', 'JavaScript', 20),
(2, 'Which one of these variables has an illegal name?', '$my-Var', '$my_Var', '$myVar', '$my-Var', 20),
(1, 'A relational database developer refers to a record as', 'A criteria.', 'A tuple.', 'A relation.', 'A tuple.', 18),
(1, 'To make your website mobile friendly, you can make your website', 'Responsive', 'Reactive', 'Fast Loading', 'Responsive', 19),
(1, 'Which of the following method sends input to a script via a URL?', 'Post', 'Get', 'Both', 'Get', 20);

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`id`, `username`, `password`) VALUES
(1, 'ahmed mohamed', '601f1889667efaebb33b8c12572835da3f027f78'),
(2, 'islam mohamed', '601f1889667efaebb33b8c12572835da3f027f78');

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `C_Id` int(11) NOT NULL,
  `S_id` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `username`, `password`) VALUES
(26, 'ahmed', '601f1889667efaebb33b8c12572835da3f027f78'),
(27, 'mohamed', '601f1889667efaebb33b8c12572835da3f027f78'),
(28, 'khalid', '601f1889667efaebb33b8c12572835da3f027f78');

-- --------------------------------------------------------

--
-- Table structure for table `teach`
--

CREATE TABLE `teach` (
  `D_id` int(11) NOT NULL,
  `S_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `D_id` (`D_id`),
  ADD KEY `s_id` (`s_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD KEY `C_id` (`C_id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD KEY `C_Id` (`C_Id`),
  ADD KEY `S_id` (`S_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teach`
--
ALTER TABLE `teach`
  ADD KEY `D_id` (`D_id`),
  ADD KEY `S_id` (`S_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`D_id`) REFERENCES `lecturer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`s_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`C_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_ibfk_1` FOREIGN KEY (`C_Id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `score_ibfk_2` FOREIGN KEY (`S_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teach`
--
ALTER TABLE `teach`
  ADD CONSTRAINT `teach_ibfk_1` FOREIGN KEY (`D_id`) REFERENCES `lecturer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teach_ibfk_2` FOREIGN KEY (`S_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
