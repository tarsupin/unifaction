<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/****** Page Configuration ******/
$config['canonical'] = "/faqs";
$config['pageTitle'] = "Frequently Asked Questions";		// Up to 70 characters. Use keywords.
Metadata::$index = true;

// Run Global Script
require(APP_PATH . "/includes/global.php");

/****** Display Header ******/
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

require(SYS_PATH . "/controller/includes/side-panel.php");

/****** Run Content ******/
echo '
<!-- Content -->
<div id="content">';
?>

<style>
	.faq-list { list-style-type:circle; list-style-position:inside; margin-left:20px; }
	.faq-list>li { margin-bottom:12px; }
</style>

<h1>FAQs</h1>

<h3>Why can't the staff answer my questions more directly, or more quickly?</h3>
<p>
	It can sometimes be difficult to understand why staff aren't able to address your questions or concerns themselves. It can be all too easy to feel that the staff is ignoring you or doesn't care. But the reality isn't so black and white. As in all things, there are a lot of things to take into consideration in this matter:
</p>

<p>
	<ul class="faq-list">
	
		<li><strong>Amount of Work</strong> - The staff can be particularly busy. UniFaction operates on over a dozen servers, each of which requires custom coding, storage, and more. Some servers even host several sites at once. There is an overwhelming amount of development that needs to be handled. Most of the system can only be accessed by a single developer. With as much time that has to be devoted to this system, many staff are too busy to deal with much else.</li>
		
		<li><strong>Time Restraints</strong> - In addition to the sheer amount of work that the staff has to deal with, there are time restraints. Real life comes into play here. Staff don't get paid to talk to the community, so that's their own free time they're giving you if they do. Some staff are already generously volunteering their time to contribute to UniFaction and make it what it is - it's their choice how they spend that time.</li>
		
		<li><strong>We Have Moderators</strong> - UniFaction has a wonderful moderation team that has volunteered their time, specifically to address your questions and concerns. They're great at their jobs, so it makes sense that they're the ones who should handle it most of the time anyway. The moderators are much better trained at getting you to where you need to be, and can do so in a much more timely fashion.</li>
		
		<li><strong>Repeat Questions</strong> - The vast majority of questions that the community asks of staff have already been asked before. User's can't possibly be expected to seek out that information every time, but neither can a staff member be expected to routinely answer a user's question every time it gets asked. If staff were to answer questions as often as individual users expected the answers, their full time job would be answering questions. Hopefully this FAQ can coordinate some of those answers into a more cohesive location to reduce that problem.</li>
		
		<li><strong>The Sake of Sanity</strong> - UniFaction was designed to be a place where everyone could get along. And while that was perhaps a pipe dream all along, it has created an atmosphere where some people can be highly sensitive about their work and dreams (*cough*). In any community there can be instances where a lot of criticism is directed at things that are created or altered in ways that some disagree with. These can often feel like personal attacks, even if they aren't meant to be (or in some cases, if they are meant to be). That can very quickly cause staff members to seek to avoid that confrontation. It's bad practice for staff to retaliate against the community, so sometimes the best option is to avoid instances where confrontation can occur. This unfortunately results in the community often not hearing directly from the staff.</li>
		
		<li><strong>The Complexity Factor</strong> - Generally, the staff has to deal with very complicated things that are far beyond the technological scope of what they can properly express on a forum. There are usually far more variables to consider than the community might even understand can exist. Saying that there are technical complications is usually sufficient to the developer who is aware of the complexity of the problem, but it can take hours to try and explain it in a way others can understand. And in those instances, usually only a comparatively tiny number of people actually take the time to understand. And this results in the staff essentially writing essays for a small group of people. That's obviously not something the staff can afford to do.</li>
		
	</ul>
</p>

<p>
	While it might seem to a user that the staff are just ignoring them or don't care about the project, the reality is that trying to involve ourselves as deeply as the community would like us to would prevent us from getting much of anything else done. Those of us who can afford some extra time may be more proactive in this matter, but others might not be as capable.
</p>

<h3>Why hasn't the community been consulted about __________?</h3>
<p>
	Following the thought process of wanting more staff involvement, users may feel like their their thoughts, comments, or feelings weren't addressed when a new feature is added or changed. This can lead to resentment and feelings that the staff are outright disregarding their interests.
</p>
<p>
	Obviously the staff has a vested interest in seeing UniFaction succeed. We want to see the community thrive, otherwise there is no point in being staff. In order for UniFaction to succeed the community needs to be impressed with the system and excited to use it and share it with friends. So the decisions we make are carefully calculated, but not always what an individual will want. Here are a few of the reasons where this issue may be easily misunderstood:
</p>

<p>
	<ul class="faq-list">
	
		<li><strong>It's Not About You</strong> - It's about the community. Everyone has ideas on how they would like something to work. If they close their eyes and envision the perfect experience for themselves, it won't match exactly what we've created. Some people will have bigger differences in mind, while others have less. In either case, there is no perfect system. Everyone has different things they'll want to use UniFaction for, and everyone is going to want a different way to experience it. The staff isn't here to build what a specific person wants - it's here to create a system that can balance a very complicated ecosystem into the best format they can do with the resources they have available.</li>
		
		<li><strong>Your Ideas ARE Being Heard</strong> - Just because the staff doesn't immediately come down and post "Hey, Joe, thanks for the idea. I'm going to implement it." or "Actually, we can't do that for very complicated technical reasons that are too complicated to explain right now." doesn't mean that we're not processing everything the community has said. The process of development requires a lot of revision work where feedback is gathered and updates are made. In a setup such as ours, the best way to get feedback is to get responses on a product. And we can (and do) get those when they're posted online.</li>
		
		<li><strong>Ideas Aren't The Issue</strong> - Ideas are like paintings. Anyone can make them, some people are extremely talented at creating them, and sometimes you get a really amazing one that fits just right - but ultimately it's all pretty subjective to taste. Almost all of the ideas possible for a solution are known well before the community even has a chance to comment on something. There are some cases where collaboration is needed (and thus is often sought out), but 95% of features aren't like that. The point that really matters is how to implement it.</li>
		
		<li><strong>Decision Complexity</strong> - In order to actually understand how to properly design and implement a working solution for a giant ecosystem of users, as well as to build it into a complicated system, a great deal of information has to be processed. Users might think their ideas are the bees-knees, and maybe they are, but that doesn't necessarily impact how a decision is going to be made. Decisions have to take into consideration many angles: development capabilities, resources available, long-term scalability, user experience, available technologies, financial return, overall brand and marketing strategy, design, customer relations, broad-community appeal, long-term sustainability and maintenance, growth and exposure potential, and many more things that extend far beyond the scope of what a typical user has access to.</li>
		
		<li><strong>Everything is a Guess</strong> - No matter how much anyone wants to believe their idea is going to work, ultimately it's all just sort of a guess. The staff have a full time job of processing the information to make educated guesses, but even we get it wrong and have to revise things frequently. Nobody can possibly expect the average user without the full spectrum of information available to them to correctly identify the appropriate decisions to make, much less ones that can fit into the overall vision of UniFaction in a way that can be adequately managed.</li>
		
		<li><strong>You could always volunteer to contribute!</strong> - If you really want to have a stronger impact on UniFaction, you can always offer to contribute work to UniFaction. Everyone has unique skills, and some of those skills can be particularly useful to UniFaction. We would love to have you help us. The more collaboration you involve yourself in, the more you can direct some of the decisions made on the system. We have some amazing things being developed on the system by people who were willing to contribute their skills and ran with it.</li>
		
	</ul>
</p>

<?php

/*
		<li><strong>Democracy is great for brainstorming, and terrible for efficiency</strong> - When a lot of people get together to come up with ideas for something, some really inspirational ideas can come to fruition. When a lot of people come together to make a decision... well... they often yell at each other and break things. The reality is that a lot of people don't listen to the expert majority. They may listen to the expert minority (ones that align with their own opinions), but in general people are far too willing to insist on things that are far outside of their own areas of expertise. So we may use this tool to identify good ideas, but it's generally a very bad way to do things to directly enable the community to decide on how to implement something.</li>
*/

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");