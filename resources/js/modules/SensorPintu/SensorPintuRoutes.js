
import SensorPintuList from "./components/SensorPintuList";
import SensorPintuForm from "./components/SensorPintuForm";

export default [
    {
        path: "/admin/sensor-pintu/",
        name: "sensor-pintu.index",
        component: SensorPintuList,
    },
    {
        path: "/admin/sensor-pintu/create",
        name: "sensor-pintu.create",
        component: SensorPintuForm,
    },
    {
        path: "/admin/sensor-pintu/:sensor_pintu/edit",
        name: "sensor-pintu.edit",
        component: SensorPintuForm,
    },
];