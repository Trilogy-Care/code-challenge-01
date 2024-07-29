Originally, I thought it made sense to create and assign the bill at the same time, but then seeing the console command 
requirements, it made sense that bills be created regardless of user.

My choice in creating the bill as DRAFT rather than SUBMITTED allows for business logic to determine when a bill becomes 
submitted. The current flow would mean additional admin work is required to change the draft bill to be submitted, in 
order to join the queue of assignable bills, but I believe that that would make sense, depending on the real life use 
case/intended user of this function.

The Feature test suite exercises the Creation and the assignment, bypassing the gap in logic mentioned above.

If this was the real world, I would recommend getting clarification on how created bills should be changed to submitted.

Please enjoy!
