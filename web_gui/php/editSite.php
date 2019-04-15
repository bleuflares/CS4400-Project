<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="refresh" content="3">

    <link rel="stylesheet" href="..\css\registerEmployeeVisitor.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <form class="form-signin">

        <h1 class="mb-3 font-weight-heavy" id="titleOfForm">Edit Site</h3>

            <div class="form-row">

                <div class="form-group row col-sm-6">
                    <label for="inputFirstName" class="label .col-form-label col-sm-4" id="firstNameLabel">Name</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputFirstName">
                    </div>
                </div>

                <div class="form-group row col-sm-6">
                    <label for="inputLastName" class="label .col-form-label col-sm-4" id="lastNameLabel">Zipcode</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputLastName">
                    </div>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group row col-sm-12">
                    <label for="inputFirstName" class="label .col-form-label col-sm-0 offset-0" id="firstNameLabel">Address</label>

                    
                        <input type="text" class="form-control col-sm-9 offset-1" id="inputAdress">
                    
                </div>

                

            </div>




            <div class="form-group row">

                <div class="form-group row col-sm-6">
                    <label for="inputFirstName" class="label .col-form-label col-sm-4" id="firstNameLabel">Manager</label>
                    <select class = "col-sm-6" style="margin-left: 1em;">
                        <option value="Yes">Option1</option>
                         <option value="No">Option2</option>
               
                    </select>

                </div>


               <div class="form-group row col-sm-6">
                    <label for="inputLastName" class="label .col-form-label col-sm-6" id="lastNameLabel">Open Everyday</label>
                    <select style="margin-left: 1em;">
                        <option value="Yes">Yes</option>
                         <option value="No">No</option>
               
                    </select>
                </div>

            </div>



            <div class="form-row">'
                <div class="form-group row col-sm-12 offset-3">
                    <button type="submit" class="btn btn-primary offset-0" id="backButton">Back</button>
                    <button type="submit" class="btn btn-primary offset-6" id="registerButton">Update</button>
                </div>
            </div>


    </form>

    <script type="text/javascript">
    </script>

</body>


</html>