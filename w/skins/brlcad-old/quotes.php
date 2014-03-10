<?php
$quotes = array();
$authors = array();

$quotes[] = 'The future exists first in the imagination, then in the will, then in reality.';
$authors[] = 'Mike Muss';

$quotes[] = 'It is proper to take alarm at the first experiment on our liberties.';
$authors[] = 'James Madison (author of the First Amendment to the U.S. Constitution, in _Memorial and Remonstrance Against Religious Assessments_)';

$quotes[] = 'We\'re mortal -- which is to say, we\'re ignorant, stupid, and sinful -- but those are only handicaps.  Our pride is that nevertheless, now and then, we do our best.  A few times we succeed.  What more dare we ask for?';
$authors[] = 'Ensign Flandry';

$quotes[] = "You don't have the right IP address.  Do not pass go.  Do not collect $200.";
$authors[] = "Paul Villano";

$quotes[] = "It's not procrastination, it's my new Just-In-Time Workload Management System!";
$authors[] = "Jim Paradis";

$quotes[] = "The trouble with paper designs is you don't get bloody enough.";
$authors[] = "Butler Lampson";

$quotes[] = "The quality of a person's life is in direct proportion to their commitment
to excellence, regardless of their chosen field of endeavor.";
$authors[] = "Vincent T. Lombardi";

$quotes[] = "Ahhh humor, the one truly effective placebo.";
$authors[] = "Bill Yeakel";

$quotes[] = "There is no conclusion, except the obvious: nothing is so simple. The
beautiful is not always the popular, the popular is not always the
trivial, the trivial not always the unimportant, and the unimportant can
be sometimes beautiful.";
$authors[] = "Alain Fournier";

$quotes[] = "Computer security should be strong enough to repel virtually any attack
***from the outside***, yet unobtrusive enough that the average user is
unaware that he is being guarded by a strong defense.";
$authors[] = "Mike Muuss";

$quotes[] = "Like a precious metal, UNIX is being beaten and molded into whatever forms
are most pleasing to the owners.";
$authors[] = "Lee A. Butler";

$quotes[] = "Sometimes you gotta create what you want to be a part of.";
$authors[] = "Geri Weitzman";

$quotes[] = "We are truly at the end of an era -- BSD UNIX and Yes are dead, the politics
of the time are conservative, the idea of having fun is becoming more and
more forbidden, the USA no longer controls its own economy, and we have
strangled ourselves by litigating against innovation.";
$authors[] = "Grey Wolf";

$quotes[] = "We stand at the brink of a deep, dark abyss.
Today we are taking a great step forward.";
$authors[] = "Robert Rosen";

$quotes[] = "This terminal is no more. It has ceased to be. It's expired and gone
to meet its maker. This is a late terminal. It's a stiff. Bereft of
life, it rests in peace. If you hadn't nailed it to the bench, it
would be pushing up the daisies. It's run down the curtain and joined
the choir invisible. This is an X-Terminal!";
$authors[] = "Unknown";

$quotes[] = "When the code and the comments disagree, both are probably wrong.";
$authors[] = "Norm Schryer";

$quotes[] = "\"Give a person the answer, they know one thing. Give a person a pointer,
they can learn it all.\"  Corollary 1: \"A True Hacker always seeks
pointers, a user wants to be spoon-fed.\"";
$authors[] = "Shashi Shekhar";

$quotes[] = "They that can give up essential liberty to obtain a little temporary
safety deserve neither liberty nor safety.";
$authors[] = "Ben Franklin, ~1784  (as quoted by Dave Farber)";

$quotes[] = "The wonderful thing about standards is that there are so many of them to
choose from.";
$authors[] = "Andrew S. Tanenbaum";

$quotes[] = "The Net interprets censorship as damage and routes around it.";
$authors[] = "John Gilmore";

$quotes[] = "If we knew what it was we were doing, it would not be called research,
would it?";
$authors[] = "Albert Einstein";

$quotes[] = "If it seems easier to subvert UNIX systems than most other systems,
the impression is a false one.  The subversion techniques are the same.
It is just that it is often easier to write, install, and use programs
on UNIX systems than on most other systems, and that is why the UNIX
system was designed in the first place.";
$authors[] = "Frederick T. Grampp & Robert H. Morris";

$quotes[] = "A professional is a person who can do his best at a time when he
doesn't particularly feel like it.";
$authors[] = "Alistair Cooke";

$quotes[] = "It is customary in the democratic countries to deplore expenditures on
armaments as conflicting with the requirements of social services. There
is a tendency to forget that the most important social service a
government can do for its people is to keep them alive and free.";
$authors[] = "British Air Marshal Sir John Slessor";

$quotes[] = "Being fearless isn't courage; courage is doing the right thing even
though you are afraid.";
$authors[] = "Jean Pettigrew";

$quotes[] = "When you measure what you are speaking about, and express it in
numbers, you know something about it. When you can not measure and you
can not express it in numbers, your knowledge is of a meager and
unsatisfactory kind. It may be the beginning of knowledge, but you have
scarcely in your thoughts advanced to the stage of science.";
$authors[] = "William Thompson, Lord Kelvin, 1891";

$quotes[] = "Small minds talk about people; average minds talk about events;
great minds talk about ideas.";
$authors[] = "Anonymous";

$quotes[] = "For software, a major upgrade takes it from Working to Not-Working.";
$authors[] = "Dave Florek";

$quotes[] = "Just because you do not take an interest in politics doesn't mean
politics won't take an interest in you.";
$authors[] = "Pericles, ruler of Athens c.430 BC";

$quotes[] = "Any intelligent fool can make things bigger, more complex, and more
violent. It takes a touch of genius -- and a lot of courage -- to move
in the opposite direction.";
$authors[] = "Albert Einstein";

$quotes[] = "Prohibition...goes beyond the bounds of reason in that it attempts to
control a man's appetite by legislation and makes a crime out of things
that are not crimes.  A prohibition law strikes a blow at the very
principles upon which our government was founded.";
$authors[] = "Abraham Lincoln, 1840";

$quotes[] = "Always dream and shoot higher than you know you can do. Don't bother
just to be better than your contemporaries or predecessors. Try to be
better than yourself.";
$authors[] = "William Faulkner";

$quotes[] = "Technology is about making things that just barely work.";
$authors[] = "Paul Ceruzzi";

$quotes[] = "Orwell had it wrong - it's not \"Big Brother\" we have to worry about,
it's \"Big Mother\" (\"It's for your own good...\")";
$authors[] = "Don Tidrow";

$quotes[] = "What is a committee? A group of the unwilling, picked from the unfit,
to do the unnecessary.";
$authors[] = "Richard Harkness, The New York Times, 1960";

$quotes[] = "Who needs Echelon when you've got web search engines?";
$authors[] = "Marcus Sachs";

function getQuote() {
	$random = mt_rand( 0, count( $quotes ) );
	return '"' . $quotes[ $random ] . '"' . ' - ' . $authors[ $random ] ;
}