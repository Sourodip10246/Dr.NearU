<?php

require_once __DIR__ . "/../models/Appointment.php";

class AppointmentController
{
    private $appointModel;

    public function __construct($pdo)
    {
        $this->appointModel = new Appointment($pdo);
    }

    public function add(array $data)
    {
        return $this->appointModel->addNewAppointment($data);
    }

    public function isExist(array $data)
    {
        return $this->appointModel->getAppointmentByDocId($data['doctor_id'], $data['appointment_date'], $data['time_slot']);
    }

    public function getTotalCount()
    {
        return $this->appointModel->countAll();
    }

    public function getAppointments($limit, $offset)
    {
        return $this->appointModel->getPaginated($limit, $offset);
    }

    public function changeStatus($id, $status)
    {
        return $this->appointModel->updateStatus($id, $status);
    }

    public function delete($id)
    {
        $stmt = $this->appointModel->deleteById($id);
        return $stmt;
    }

    public function getPatientCount()
    {
        return $this->appointModel->countPatient();
    }

    public function getRecentAppointments()
    {
        return $this->appointModel->showRecentBookedAppointment();
    }

    public function getAppointmentsChartData($range)
    {
        $from = $to = null;
        $labels = [];
        $data = [];

        switch ($range) {
            case 'this_week':
            case 'last_week':
                $from = $range === 'this_week'
                    ? date('Y-m-d', strtotime('monday this week'))
                    : date('Y-m-d', strtotime('monday last week'));
                $to = $range === 'this_week'
                    ? date('Y-m-d', strtotime('sunday this week'))
                    : date('Y-m-d', strtotime('sunday last week'));

                $results = $this->appointModel->getWeeklyAppointments($from, $to);

                $map = [];
                $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                $dateKeys = [];
                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', strtotime($from . " +$i days"));
                    $dateKeys[$date] = $labels[$i];
                    $map[$labels[$i]] = 0;
                }
                foreach ($results as $row) {
                    $map[$dateKeys[$row['day']]] = (int)$row['total'];
                }
                $data = array_values($map);
                break;

            case 'this_month':
            case 'last_month':
                $from = $range === 'this_month'
                    ? date('Y-m-01')
                    : date('Y-m-01', strtotime('first day of last month'));
                $to = $range === 'this_month'
                    ? date('Y-m-t')
                    : date('Y-m-t', strtotime('last day of last month'));

                $results = $this->appointModel->getMonthlyAppointments($from, $to);

                $map = [];
                $daysInMonth = date('t', strtotime($from));
                $labels = range(1, (int)$daysInMonth);
                foreach ($labels as $day) {
                    $date = date('Y-m', strtotime($from)) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                    $map[$date] = 0;
                }
                foreach ($results as $row) {
                    $map[$row['day']] = (int)$row['total'];
                }
                $data = array_values($map);
                break;

            case 'this_year':
            case 'last_year':
                $from = $range === 'this_year'
                    ? date('Y-01-01')
                    : date('Y-01-01', strtotime('-1 year'));
                $to = $range === 'this_year'
                    ? date('Y-12-31')
                    : date('Y-12-31', strtotime('-1 year'));

                $results = $this->appointModel->getYearlyAppointments($from, $to);

                $labels = range(1, 12);  // 1 to 12
                $map = [];
                foreach ($labels as $monthNum) {
                    $map[$monthNum] = 0;
                }
                foreach ($results as $row) {
                    $map[(int)$row['month']] = (int)$row['total'];
                }
                $data = array_values($map);
                break;

            default:
                echo json_encode(['labels' => [], 'data' => []]);
                return;
        }

        return json_encode([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
