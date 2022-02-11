<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    .card-header {
      padding: 1rem 1rem;
      margin-bottom: 0;
      background-color: rgba(0, 0, 0, 0.03);
      border-bottom: 1px solid rgba(0, 0, 0, 0.125);
      text-align: center;
    }

    .table {
      width: 50%;
      margin: 0 auto;
      margin-bottom: 1rem;
      color: #212529;
      vertical-align: top;
      border-color: #dee2e6;
      caption-side: bottom;
      border-collapse: collapse;
    }

    td {
      width: 50%;
      padding: 15px;
    }

    tr:nth-child(even) {
      background-color: rgba(0, 0, 0, 0.05);
    }
  </style>
</head>

<body>
  <h2 class="card-header">
    Payroll Detail
  </h2>

  <table class="table table-striped">
    <tr>
      <td>Name</td>
      <td>{{ $calculatedPayroll->employee->name }}</td>
    </tr>
      <tr>
        <td>Basic Salary</td>
        <td>{{ $calculatedPayroll->employee->salary->basic_salary }}</td>
      </tr>
      <tr>
        <td>Basic Leave Fine</td>
        <td>{{ $calculatedPayroll->employee->salary->leave_fine }}</td>
      </tr>
      <tr>
        <td>Basic Overtime Fee</td>
        <td>{{ $calculatedPayroll->employee->salary->overtime_fee }}</td>
      </tr>
      <tr>
        <td>Actual Working Days</td>
        <td>{{ $monthlyWorkingDays }}</td>
      </tr>
      <tr>
        <td>Your Working Days</td>
        <td>{{ $calculatedPayroll->employee->working_days }}</td>
      </tr>
      <tr>
        <td>Your Leave Days</td>
        <td>{{ $calculatedPayroll->total_leave_days }}</td>
      </tr>
      <tr>
        <td>Your Overtimes</td>
        <td>{{ $calculatedPayroll->total_overtimes }}</td>
      </tr>
      <tr>
        <td>Your Leave Fines</td>
        <td>-{{ $calculatedPayroll->total_leave_fines }}</td>
      </tr>
      <tr>
        <td>Your Overtime Fees</td>
        <td>+{{ $calculatedPayroll->total_overtime_fees }}</td>
      </tr>
      <tr>
        <td>Total Final Salary</td>
        <td>{{ $calculatedPayroll->salary }}</td>
      </tr>
  </table>
</body>

</html>
