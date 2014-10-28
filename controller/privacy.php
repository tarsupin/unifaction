<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/****** Page Configuration ******/
$config['canonical'] = "/privacy";
$config['pageTitle'] = "Privacy Policy";		// Up to 70 characters. Use keywords.
// Metadata::openGraph($title, $image, $url, $desc, $type);		// Title = up to 95 chars.

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

<h2>Privacy Policy</h2>
<p>Privacy has become an important issue, and I want everyone that uses UniFaction to fully understand their privacy both on this website and around the internet. Even if you already trust UniFaction with your information, I feel that it’s important to understand why. So I’ve written a comprehensive document detailing the most important things you should know about privacy and security of your information. This document is intended primarily for UniFaction, but will also provide useful privacy tips for all online interactions, regardless of which sites you use.</p>

<strong>What are you doing to protect my privacy?</strong>
<p>The most important thing we can possibly do to protect your privacy is to educate you about it. That might sound cliché, but anyone who hasn't exhaustively studied privacy doesn't necessarily understand the consequences of their privacy. The knowledge in this document will possibly do a better job of protecting your privacy than anything a website could offer. It will empower you to make the right decisions concerning what you share, what you keep private, and how all of those decisions matter.</p>

<p>Additionally, we will be actively seeking to protect our users rather than exploit them by forcing them into decisions that they aren’t aware of or don’t have any choice in agreeing to. When companies do that (and a lot of them do), it is incredibly dishonest and shameful. No site should ever treat their users in that way. UniFaction’s policy is to be transparent, honest, and helpful about what you want to exchange and what you don’t. Our goal is to help you understand this system and to clearly explain how our inner workings operate without being concealed behind a wall of legal mumbo jumbo. This eliminates the barrier to understanding our system and allows the public to scrutinize our policies for the betterment of the system.</p>

<p>However, this transparency works two ways. We will make the effort to give you the full, clear understanding of how we are protecting you and your information. But you also have a responsibility to seek out and utilize the knowledge that we have provided. Since we expect you to review this policy, we have made it so that this policy covers ALL of the official UniFaction sites.</p>

<strong>What information is considered public vs. private?</strong>
<p>UniFaction is a social system, so there’s a lot of public content. If you are posting to a UniFaction site that doesn’t have permissions built into it, that information is considered to be public. Most of the private information that will be exchanged on our system is within the private messages, your social pages (only if you choose for them to be private), settings, and authentication (i.e. login and passwords).</p>

<p>Obviously if you’re posting a message to a public site that anyone can connect to, that would be considered public. Our assumption is that you meant it to be, so we freely distribute that information on UniFaction, enable others to re-share it, etc. The social aspects of this system may often sync up with that content automatically to keep track of your data.</p>

<strong>What information gets collected on me?</strong>
<p>As a web developer, I can assure you that there is a LOT of information being gathered about you around the internet – everywhere – and most of the time it is for totally legitimate reasons. When it comes to large websites (and especially the most popular websites), you can safely assume that just about anything you can type or click on is being tracked and collected. That means any search you make, any friend you click on, ANYTHING you do is possibly going to be stored somewhere to gather information about you.</p>

<p>Now, as ominous as that sounds (and before I start a panic over that revelation) let me explain more on this. The decision to track that information isn’t part of a giant conspiracy. Knowing that you ate blueberry muffins this morning probably isn’t going to feed the government with particularly useful intelligence that will haunt you in later years. Most of the information gathered on you is completely harmless and is done for a number of reasons. For example: automatic logins, better search results, identifying better web techniques, improving the user experience, identifying optimizations, improving popularity, matching compatible users, providing useful content, more related and effective content delivery, and even improved security are just a few reasons. Data mining is a powerful tool that can be used for considerable good (when used for good reasons).</p>

<p>For everything that’s being tracked about you online there’s *probably* a non-conspiratorial reason for having tracked it, but of course that doesn’t stop some organizations from trying to use it for shady or unethical purposes. Our goal at UniFaction is to provide a safe environment where any information tracked about you remains private when it should and we take MANY measures to ensure your information is protected. It is an embarrassment to any site that fails to protect their users, and we do not want to be one of those sites. One of the first ways we want to help is to provide transparency about our practices. Again, as a reminder, part of the responsibility still falls upon you to understand these policies.</p>

<p>It’s also important to distinguish between collecting information on “you” vs. the computer that you’re connected to. A lot of information that sites track is just related to your computer and has no actual connection to you as an individual. However, UniFaction is a social site. Therefore, we collect information about “you” as well as your computer.</p>

<p>The information that we gather about you is, of course, the information that you voluntarily provide to UniFaction. If you post a message on your social profile, obviously that information has to be stored on our system for it to be displayed to someone else. Any text or images that you post on the system, anywhere, will be saved into our databases for retrieval by others. Some of our sites offer private channels for communication. The information is still saved normally, but permissions settings are used to identify valid parties that can access that information. Any parties without the necessary permissions will be restricted from that information.</p>

<p>There is data that is unavoidable to collect. Obviously we have to collect every post, comment, like, favorite, image, and other type of data processed in order to actually run the site. We also gather data that is not necessarily required, but which helps us to improve user experience. For example, if you spend a lot of time browsing arcade games, we might use that to serve you more content related to arcade games. This allows us to serve better content and be profitable with advertising.</p>

<strong>What quick security tips can you provide me?</strong>
<p>Do not, under any circumstances, give your personal information or password to a site that you're registered to. UniFaction would never ask for your password or any details about you, and neither will any legitimate company. If you ever receive an email claiming that we're asking you for a password or personal details, someone is "phishing" for information. Please report any such emails to us. Unless you have prompted something on the site (such as to reset your password), we don't send you email.</p>

<p>The only possible exception to this is if you lost your password AND your email, and the only way we can safely give you your account back is to verify personal information about you. The issue in these circumstances is that if you don't have your email or your password, there is almost nothing that can prove you should own the account, especially if the account was designed to not contain any personal information. Therefore, in situations like this, there will very heavy security measures in place before returning an account to you. We may or may not even be able to offer this service at this time due to the amount of time it would take to handle this task. However, we will try to provide options for you that will ensure you can keep your account safe.</p>

<strong>How does marketing fit into your privacy policy?</strong>
<p>The first question on everyone’s mind is usually “are you going to sell my information.” To which the answer is NO! UniFaction will NEVER voluntarily sell your private information or give it to any third party, unless it is our legal obligation to do so. UniFaction does NOT need to sell your data to use it for marketing purposes or advertising.</p>

<p>It’s worth spending some time understanding how this works so that you can understand *why* we won’t sell your data. Big sites have to be competitive with marketing. And marketers don’t care about views and clicks, they care about conversions. It doesn’t matter if you show 1 million gardening enthusiasts your ad about finding local web developers. But it does matter if you get 100 senior web developers to view it. So if you type in “web developers” in a search engine, a site might keep that information to identify you as a potential client in web development for prospective advertisers.</p>

<p>Prospective advertisers don’t need that data, though. If an advertiser comes to us and says “we want to sell soccer balls”, then we say “okay” and run a soccer ball ad when people type in “soccer.” We might also run it on soccer-related pages, or when someone has shown a strong interest in soccer-related things. But the advertiser never collects that data. All they did was provide the advertisement and let us run the algorithms to deliver the content.</p>

<p>Even if advertisers were taken out of the picture, however, the same information would still be tracked to provide you a better user experience. Having to sift through 90% less content to find the stuff you enjoy is something that keeps people coming back to a site. Therefore, we also track such useful connections to ensure the users have a good time.</p>

<p>However, this data collection can also be used for bad purposes, which is why a lot of sites get some pretty negative press about it. If a site is collecting information for the right purposes, they don’t need to sell that information to third parties. Selling that information without your express consent is something I would consider a heavy abuse of your information. It’s inappropriate, it’s an awful practice, and it shouldn’t happen. And it’s the reason why a lot of people are weary about putting their information online. So let me clarify this again in caps: WE DO NOT SELL YOUR PRIVATE DATA TO THIRD PARTIES. If a site wants to establish trust with their users, those users should clearly understand what’s being done with that information.</p>

<p>I can discuss more about the marketing side of things later. But for now, remember that UniFaction will never voluntarily provide or sell out your information to third parties. If you want an experience that we can’t offer without sharing that information, we will provide a very clear policy that enables you to understand what is happening. That means you’ll never be unwittingly sold out by UniFaction of our free choice.</p>

<strong>Is there any information that gets shared with third parties?</strong>
<p>Any information that is public (that is, anyone can view it on UniFaction) can be acquired freely by third parties. It’s as simple as visiting the public page and copy/pasting it. Other sites might “scrape” our pages with web crawlers that collect the information. Search engines might search through our content and post links directly to it. Some sites might download the data and run algorithms on it for their own purposes.</p>

<p>Simply put: if you post something that can be accessed publicly it becomes available to anyone and everyone in the world. There’s nothing that we can do to prevent any information from being gathered if you post it publicly. This is important to know, because data collection happens across sites. In fact, the whole purpose of search engines is to gather data on other sites and display it somewhere else. There are a lot of sites that do similar things, so keep this in mind when you’re posting content.</p>

<p>In addition to any information that is made public, we might also provide APIs that allow people to connect to information on our servers.</p>

<strong>What about third-party APIs?</strong>
<p>This section is where things get insanely complicated, so please bear with us and read this very carefully. It’s important to understand the entire context of what I’m explaining here.</p>

<p>API’s, or Application Programming Interfaces, are used to allow different parties to connect to each other. Specifically, this is done to exchange data and information. For example, we might build an API to allow other sites to see a feed of our most recent blog posts. This would mean that we are enabling third parties to use a special program to access our data – data that might have been originally created by you.</p>

<p>That’s where the whole ordeal with data and “third parties” becomes a nightmare to explain in simple terms. We can’t just say “we won’t send your data to third parties” because even simple widgets that provide the ability to link to us does that. And if we said we wouldn’t share data, we’d throwing away amazing features that aren’t even related to privacy. Unfortunately, the terminology is also difficult. Telling someone with technical experience that you’re exchanging data between two sites might result in “Well, yeah.” But telling someone without technical experience that their information is being transferred to another site might result in a flurry of concern about invasions of privacy that can be painfully difficult to explain how that's not actually a privacy invasion.</p>

<p>To address it in simpler terms, consider any of the sites you browse regularly. Have you ever seen a blog feed, news feed, a hashtag widget, or a list of “share” or “like” buttons on those sites? Those are just a few examples of APIs. They allow other sites to connect to them and gather that information to provide great functionality across the internet. They’re harmless tools that allow different sites to access a repository of useful features.</p>

<p>Earlier in this document we indicated that “UniFaction will NEVER voluntarily sell your private information or give it to any third party, unless it is our legal obligation to do so.” The key phrase here is “private information” – information that you would not want being shared with third parties. It’s important to clarify that now since our goal is transparency and we don’t want to mislead anyone.</p>

<p>The problem is that when people discuss “information that you would not want being shared with third parties” there may be a fraction of that content that would be subjective on an individual basis, which may disagree from the general masses. We can’t conceivably pin down each distinction to everyone’s satisfaction, but we are committed to ensuring that the general masses would always side with how we operate with private data. What we *don't* want to do though is bog everyone down with a thousand opt-in choices for every little detail. Not only is that impractical for a thousand reasons, it would ruin the user experience and nobody would use the site in the first place. Therefore, we are going to make the most intelligent balance we can.</p>

<p>So to ensure that our site is user-friendly, we’re going to run as few opt-in or opt-out choices that we can. At the same time, we’re going to do what we feel maintains a proper degree of privacy on our sites. Obviously our goal is to make sure that users trust us, so we intend to be transparent about the process so that we don’t misrepresent our user’s understanding of privacy.</p>

<strong>What am I consenting to?</strong>
<p>This is one of the most important things I want to address and have everyone understand. In a lot of sites, consenting to things is done by agreeing to a TOS filled with pages of legal jargon that aren’t helpful to anyone. UniFaction tries to avoid that and make things easy to understand. When we ask you to consent to something, we mean we want you to clearly understand the decision you are making (or at the very least, we enabled you to make a clear decision), and you consciously chose to say yes to it. We will not bury or obscure agreements in baffling legal text. And we will not intentionally restrict content from you unless the content literally requires consent to work.</p>

<p>So in some cases the more important factor is what you’re NOT consenting to. By default, nobody on this site will have their privacy violated by having us voluntarily sell, share, or otherwise exchange their private information to a third party. If there are functions on the site that could potentially violate user’s privacy and threaten the trust with our users, then the option would be disabled by default until you have consciously decided to opt-in.</p>

<strong>Is the NSA / government going to get my information from you?</strong>
<p>We’ve mentioned that we will never voluntarily share your private information. This is true. However, if UniFaction is legally forced to comply with an exchange of information, we will do so while being as transparent about it as is legally allowed. For those of you who are strong advocates of privacy, there does appear to be some progress being made toward these transparencies.</p>

<p>But the reality is that the government can do whatever it wants with secret courts. Our site. Other sites. Doesn't matter. You may have seen companies in the news saying “Our security is great! The Feds hate us!” - Right. That's PR at it's finest, but that's all it is. Sorry to be the bearer of bad news, but if you really want true privacy, ending the government's secret court orders is the only way to do it. Until then, all the PR you see about security is nonsense. A business owner could have the strongest door in the world, but if the cops knock on it, he still has to let them in.</p>

<p>On the other side of things, however, is that there really *are* bad guys in the world. UniFaction wants to ensure that we can help bring them to justice. If anyone is using our site to bring harm to other people, that goes against our TOS. You can be sure that we want to stop those people, and that we would encourage law enforcement agencies to do the same. However, this brings up more complicated questions. Everyone wants the bad guys caught, but to do that their private information might be indirectly considered as relevant in some instances. Where is the line drawn?</p>

<p>This means that the terminology is once again very difficult to hammer down, so we appended the “unless it is our legal obligation to do so” part of our message. If there are illegal activities happening on our site, then we have a legal obligation to do the right thing and inform the right people. And we will make a best effort attempt to do so, and we will cooperate with the law to do so. As long as you’re not doing anything illegal on our site, however, you are not subject to those conditions.</p>

<p>In regard to the original question, “will the government get my information,” the answer goes deeper than just UniFaction. It’s important to remember that unless you have been concealing yourself from “the grid” (the internet and any business/government systems that can track data on you), you can safely assume that the government is VASTLY more informed about you than we are. For example, the government has access to your ISP (internet service provider). Everything you do online goes through your ISP, so anything you do online can be accessed by the government. Your information is actually transferred to more points than that, which UniFaction has no control over. Think of it like trying to throw a ball down a hallway. When it gets to the end, its in our hands. Any time between that, someone can watch it roll. And it might just be someone paid to watch.</p>

<p>As long as what you’re adding to our site doesn’t upset the government, most of what you provide us is much more likely to be interesting to other users than it is to the government. Of course, that’s an over-simplification of how things could hypothetically work, but relevant nonetheless.</p>

<p>To summarize this portion, our statement remains the same. We will never voluntarily share your private data on our site unless we are legally obligated to do so.</p>

<strong>So are advertisers going to get my information from you?</strong>
<p>In case anyone skipped over the context earlier in this document: NO. Advertising is often necessary to run a site, but the people selling a product don’t need your private data to be able to advertise to you. If our database knows that you enjoy playing soccer, then it doesn’t matter if the seller knows that. They can just say “we’d like to share this ad with people who play soccer.” Then our data can handle that targeting for them.</p>

<p>So while there’s a lot of money to be made in selling your private data, I don’t care. I am not looking to sell your private information. That would be an abuse of your trust, and that’s not how I want to run this company.</p>

<strong>Are you ever going to change your mind?</strong>
<p>No. Because our company is actually awesome. By default, we will always treat your private information as private and never exchange it voluntarily. If this company ever starts providing your information in a way that conflicts with what I’ve just said above, it’s because we’re being forced to. In some cases it’s still in your best interest to keep private things to yourself, but I can explain more on that later.</p>

<strong>How are you storing my password? Is it secure?</strong>
<p>It’s a little mind-boggling how insecure some production code is and how passwords get handled. There are still sites that store passwords with weak hash algorithms or even in plaintext (if you don’t understand what that means, I’ll explain that below). If a worst case scenario happens and the database passwords get stolen (which really shouldn't happen either), it’s absurdity that passwords aren’t heavily protected. This is actually an important topic to go over; understanding how people obtain passwords can help you protect yourself on other sites.</p>

<p>For example, did you know that a common technique of discovering your password is to hack a different site that you’ve visited (such as a simple forum that someone created), and then trying that password on your email or other sites that you visit? So if you use the same password on a weakly-secured website as you do somewhere else, you’re risking the exposure of that password. If you re-use passwords, your security is also tied to the security of the weakest link. This is why it’s *strongly* recommended to use different passwords on different sites.</p>

<p>UniFaction is very unique in how it uses logins. We only have one master login across all of our domains, and thus only one password. When you log into a UniFaction site, you don’t need to remember another password. This means that you can dedicate your memory to one very strong password rather than dozens of weak ones. This strengthens your password in two ways: you can remember a much stronger password, and there are less points of entry to deal with.</p>

<p>As for how UniFaction stores passwords, we start by encrypting it with an incredibly strong 512-bit encryption algorithm. Every password is separately salted, eliminating the use of rainbow tables and making brute force ineffective against the batch. The algorithm is designed to protect against timing attacks and was also intentionally slowed down (improves security), with the ability to modify the entire system with a simple code modification. With our current level of technology, every computer in the world couldn’t collectively break a good password through brute force alone if given a trillion years to do so.</p>

<p>However, I want you to pay attention to a key word there. I said it couldn’t break through a “good password” for a reason. If your password is “kittens”, a brute force algorithm is still going to scan through a dictionary list of words and attempt to match that algorithm very quickly. However, that isn't entirely relevant with UniFaction, but the explanation of that gets more technical.</p>

<p>To understand what I'm referring to in general, you should understand how a password gets saved. We don’t actually save the word “kittens” in our database, we store what is called a hash of the password. The password can’t be reversed – you have to start with the original password and then see what happens when you use the hash algorithm on it.</p>

<p>Let’s say, for example, that we start with the password “kittens” and apply a “red filter” algorithm to it. When we pass the red filter over the password, it now looks like this: “ab9:dio238*F8,s?3wo*mvD1lek#b3”. But if you pass the red filter over “puppies” it would create an entirely different “hash” of the password because kittens and puppies look different under a red filter. So when you register on UniFaction with “kittens”, we shine a red filter over your password and save the result. When you log back in and write “kittens”, UniFaction shines the red light on it again to see if it matches “ab9:dio238*F8,s?3wo*mvD1lek#b3”. If it does, then it says “Okay, you’ve clearly entered the right password” and lets you in.</p>

<p>It’s theoretically possible that another password could also look the same when the red filter is passed over it. These are called “collisions”, which are nearly impossible to get to occur with properly built high-bit algorithms (such as the one we are using). This point is insignificant due to the nature of the algorithms we use anyway, but it’s interesting to know.</p>

<p>If someone gains access to your account with your password, security experts around the internet would say there’s really no likelihood that it was the result of our password encryption being weak. The algorithms used have been well established in the cryptographic communities. So if someone has accessed your account, you should immediately take steps to correct some of the more common mistakes.</p>

<strong>What about data transference? Can my information be sniffed?</strong>
<p>In some cases, people’s passwords are revealed when someone is “sniffing” the traffic between their computer and the server, such as at a shared router. Since most traffic passed through a computer is sent without encryption, this means that unencrypted transfers might be revealed through snooping techniques.</p>

<p>Unfortunately, even SSH has it's limitations against someone who really knows what they're doing (granted, it does help considerably). To truly protect your password from being stolen you should avoid connecting through any unsecured connection, such as in a bookstore or a cafe. This also helps avoid any forgetfulness about logging out of sites when you're finished (one of the most common “hacks” as the media likes to say).</p>

<strong>What steps can I take to protect my password?</strong>
<p>First, come up with a difficult password. Use a variety of letters, numbers, and symbols in combinations that aren’t easy even for you. If it’s too easy for you to remember, it’s too easy. For example, security experts know the trick where you change e’s with 3’s. A lot of people try to strengthen their passwords with something like “h3llo” to prevent dictionary attacks or simple guesses. In practice, that is not strong enough. Many decryption algorithms these days will tailor themselves to your psychology and the shortcuts we use when making passwords (like using keys in a row). Be mindful of this. The longer your password is, the better, but it’s just as important to have it be genuinely complicated.</p>

<p>Second, a lot of internet traffic is unencrypted. This can become a particular risk if you’re on a public web connection, such as in a coffee shop. If you’re accessing websites from a public internet connection, don’t forget that any information you send is visible to someone anyone else on that connection knows what they’re doing. It can be more secure to connect with SSL (the “https” instead of “http”), but even that has been proven to be insecure against certain attacks.</p>

<p>Third, avoid logging into systems on public computers. People forget that leaving a site doesn’t necessarily mean that the cookies that kept you logged in are gone. Someone else might be able to log right back into that site the moment you step away. It’s too easy to be rushed away at a moment’s notice or not remember to log out of everything you were visiting to risk that. Even someone without any security skills can take over an account like this. Be cautious of what you’re doing.</p>

<p>Some of the dangers beyond these practical steps above tend to involve protecting your computer and becoming somewhat of a security expert yourself. I may touch on those subjects in other articles if you’re interested in learning more.</p>

<strong>Is your site secure? Am I safe here?</strong>
<p>I’ve built the entire system with security as one of my primary objectives, so hopefully the answer to that is yes. I can certainly testify that it’s considerably more secure than the sites I’ve worked on in professional development. Generally the biggest reason for major security breaks is a lack of paying attention to security or a general lack of knowledge on the subject when developing it. This is a major system with a lot of intricate parts to it, but there was also a significant amount of effort put toward making sure the system was heavily protected.</p>

<p>As a good example of this, UniFaction doesn’t rely on blacklisting practices as a core function of the site (which is common with many websites). All of our input is sanitized with a whitelist. And if any suspicious inputs are used, the system tracks that information in the database along with specific indicators that would be of interest to us. We’re actively protecting against XSS, session hijacking, dangerous uploads, and more. If you’re uncertain what these mean (or why they’re relevant), we will probably write up some articles on security and publish them at a later time.</p>

<p>If there is a serious break in the system, however, I will seek to rectify the situation as soon as possible. I intend to do this by enabling security experts (some might refer to them more commonly as hackers) to review the site freely without consequence (as long as they’re using it to inform us, not hurt us).</p>

<strong>What about Hackers? Are they going to be on this site?</strong>
<p>I plan on encouraging hackers to use this site. I want professional security experts trying to break into this system, and they are free to do so as long as they follow the rules I request. The entire web is built around software that needs to be tested for reliability. By encouraging hackers and security experts to find whatever exploits they can, we find ways to resolve problems rather than trying to hide from them. There are companies that, for some insane reason, punish hackers that are trying to help expose flaws in their system. That’s a terrible and stupid practice and indicates management that has no comprehension of why they should be listening to security experts. We can’t improve our security by telling good, honest people not to poke at it.</p>

<p>So to any hackers out there that want to see what you can do on this system, you’re free to do so as long as you agree to reveal those bugs to us privately so that we can fix them. Once we fix them and can confirm that the new system is safe (and any related systems are as well), we’re happy to give you credit for having discovered it.</p>

<strong>How do the anonymous accounts work on UniFaction?</strong>
<p>When you create an anonymous profile (alias) on UniFaction, it is important to understand what that profile DOES and DOES NOT do to maintain your anonymity. Technically, any profile you have on UniFaction can be treated as an anonymous account if you do not disclose any personal information about yourself on it. For example, if your name is John Smith, but you describe yourself as Barry Johnson and have an image of a silhouette (i.e. don't show yourself), you can maintain anonymity simply by the fact that your personal information isn't real.</p>

<p>All profile on UniFaction are also considered "separate" from each other, so there is nothing that ties your personal profile to your business profile UNLESS you (or someone you know) were to reveal that these profiles were related to each other. For example, if your personal profile was "John Smith" and your business profile was "John A. Smith" and you linked to your business profile from your personal one, any anonymity that your business profile had is now gone. The same is true of your alias profile. If you tell anyone who you really are with the profile you've designated for anonymity, you are no longer anonymous on that profile.</p>

<p>Therefore, in order to stay anonymous on an anonymous profile, you need to carefully consider what information you post on that profile. Depending on how careful you want to be, you'll need to ensure that you don't post anything that could give away who you might be. Even if you're only telling people the places you've visited or the types of flowers you were looking at today, it is possible for people to search through clues about you and start narrowing down where you live, what gender you are, etc. Technically, people with a strong interest in forensics can probably determine quite a bit about you simply with the words you use or the way you say things. So, as mentioned earlier, how cautious you want to be is really up to you.</p>

<p>An anonymous profile does NOT mean that UniFaction doesn't know about your profile. UniFaction stores information about your profiles, otherwise you wouldn't be able to use the profile in the first place.</p>

<p>Finally, anonymous profiles should be using all of the privacy techniques we've discussed throughout this entire document. Someone who is more serious about breaking your level of anonymity than you are in protecting it will eventually find a way to do so. Therefore, knowledge is one of your best defences, and actively pursuing these privacy techniques will go a very long way to protecting you.</p>

<strong>Is there any other information I should know?</strong>
<p>Yes, there's a lot more information you should know. I don't claim that this document is a comprehensive list of everything that users should understand about internet privacy, but I do think it's a good first step. Hopefully you've found some information here that can lead you to the right questions to find out anything else you need.</p>

<?php
echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");