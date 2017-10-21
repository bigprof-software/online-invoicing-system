var FiltersEnabled = 0; // if your not going to use transitions or filters in any of the tips set this to 0
var spacer="&nbsp; &nbsp; &nbsp; ";

// email notifications to admin
notifyAdminNewMembers0Tip=["", spacer+"No email notifications to admin."];
notifyAdminNewMembers1Tip=["", spacer+"Notify admin only when a new member is waiting for approval."];
notifyAdminNewMembers2Tip=["", spacer+"Notify admin for all new sign-ups."];

// visitorSignup
visitorSignup0Tip=["", spacer+"If this option is selected, visitors will not be able to join this group unless the admin manually moves them to this group from the admin area."];
visitorSignup1Tip=["", spacer+"If this option is selected, visitors can join this group but will not be able to sign in unless the admin approves them from the admin area."];
visitorSignup2Tip=["", spacer+"If this option is selected, visitors can join this group and will be able to sign in instantly with no need for admin approval."];

// invoices table
invoices_addTip=["",spacer+"This option allows all members of the group to add records to the 'Invoices' table. A member who adds a record to the table becomes the 'owner' of that record."];

invoices_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Invoices' table."];
invoices_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Invoices' table."];
invoices_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Invoices' table."];
invoices_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Invoices' table."];

invoices_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Invoices' table."];
invoices_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Invoices' table."];
invoices_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Invoices' table."];
invoices_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Invoices' table, regardless of their owner."];

invoices_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Invoices' table."];
invoices_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Invoices' table."];
invoices_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Invoices' table."];
invoices_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Invoices' table."];

// clients table
clients_addTip=["",spacer+"This option allows all members of the group to add records to the 'Clients' table. A member who adds a record to the table becomes the 'owner' of that record."];

clients_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Clients' table."];
clients_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Clients' table."];
clients_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Clients' table."];
clients_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Clients' table."];

clients_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Clients' table."];
clients_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Clients' table."];
clients_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Clients' table."];
clients_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Clients' table, regardless of their owner."];

clients_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Clients' table."];
clients_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Clients' table."];
clients_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Clients' table."];
clients_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Clients' table."];

// item_prices table
item_prices_addTip=["",spacer+"This option allows all members of the group to add records to the 'Prices History' table. A member who adds a record to the table becomes the 'owner' of that record."];

item_prices_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Prices History' table."];
item_prices_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Prices History' table."];
item_prices_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Prices History' table."];
item_prices_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Prices History' table."];

item_prices_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Prices History' table."];
item_prices_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Prices History' table."];
item_prices_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Prices History' table."];
item_prices_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Prices History' table, regardless of their owner."];

item_prices_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Prices History' table."];
item_prices_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Prices History' table."];
item_prices_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Prices History' table."];
item_prices_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Prices History' table."];

// invoice_items table
invoice_items_addTip=["",spacer+"This option allows all members of the group to add records to the 'Invoice items' table. A member who adds a record to the table becomes the 'owner' of that record."];

invoice_items_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Invoice items' table."];
invoice_items_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Invoice items' table."];
invoice_items_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Invoice items' table."];
invoice_items_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Invoice items' table."];

invoice_items_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Invoice items' table."];
invoice_items_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Invoice items' table."];
invoice_items_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Invoice items' table."];
invoice_items_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Invoice items' table, regardless of their owner."];

invoice_items_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Invoice items' table."];
invoice_items_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Invoice items' table."];
invoice_items_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Invoice items' table."];
invoice_items_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Invoice items' table."];

// items table
items_addTip=["",spacer+"This option allows all members of the group to add records to the 'Items' table. A member who adds a record to the table becomes the 'owner' of that record."];

items_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Items' table."];
items_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Items' table."];
items_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Items' table."];
items_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Items' table."];

items_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Items' table."];
items_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Items' table."];
items_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Items' table."];
items_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Items' table, regardless of their owner."];

items_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Items' table."];
items_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Items' table."];
items_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Items' table."];
items_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Items' table."];

/*
	Style syntax:
	-------------
	[TitleColor,TextColor,TitleBgColor,TextBgColor,TitleBgImag,TextBgImag,TitleTextAlign,
	TextTextAlign,TitleFontFace,TextFontFace, TipPosition, StickyStyle, TitleFontSize,
	TextFontSize, Width, Height, BorderSize, PadTextArea, CoordinateX , CoordinateY,
	TransitionNumber, TransitionDuration, TransparencyLevel ,ShadowType, ShadowColor]

*/

toolTipStyle=["white","#00008B","#000099","#E6E6FA","","images/helpBg.gif","","","","\"Trebuchet MS\", sans-serif","","","","3",400,"",1,2,10,10,51,1,0,"",""];

applyCssFilter();
