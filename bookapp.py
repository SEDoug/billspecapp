import xlrd
import MySQLdb

# Open the workbook and define the worksheet
book = xlrd.open_workbook("uploads/asu_bill_spec_rev2.xls")
#sheet = book.sheet_by_name("source")
sheet = book.sheet_by_index(0)

# Establish a MySQL connection
database = MySQLdb.connect (host="localhost", user = "root", passwd = "123456", db = "billspec", use_unicode=True, charset="utf8")
# to secure the password above consider setting the path to a user configuration file using: read_default_file

# Get the cursor, which is used to traverse the database, line by line
cursor = database.cursor()

# Create the INSERT INFO sql query
query = """INSERT INTO File_Header (Column_name, Description, Length, Start_Position, End_Position, Value, Required) VALUES (%s, %s, %s, %s, %s, %s, %s)"""

# Create a For loop to iterate through each row in the XLS file, starting at row 2 to skip the headers
for r in range(1, sheet.nrows):
	Column_name			= sheet.cell(r,1).value
	Description			= sheet.cell(r,2).value
	Length				= sheet.cell(r,3).value
	Start_Position		= sheet.cell(r,4).value
	End_Position		= sheet.cell(r,5).value
	Value				= sheet.cell(r,6).value
	Required			= sheet.cell(r,7).value

	# Assign values for each row
	values = (Column_name, Description, Length, Start_Position, End_Position, Value, Required)

	# Execute sql Query
	cursor.execute(query, values)

# Close the cursor
cursor.close()

# Commit the transaction
database.commit()

# Close the database connection
database.close()

# Print Results
print ""
print "All done! Exiting now."
columns = str(sheet.ncols)
rows = str(sheet.nrows)
print "I just imported " + columns + " columns and " + rows + " rows to MySQL!"
