import React from "react";
import { useState, useEffect } from "react";

const fighter_id = document.body.getAttribute("fighter_id");

const battleground_id = document
    .getElementById("entry_battleground")
    .getAttribute("battleground_id");

export default function Timer({
    end_timer,
    time_point,
    count,
    setPlay,
    winner,
}) {
    const [minutes, setMinutes] = useState(0);
    const [seconds, setSeconds] = useState(0);

    async function setTimer(remain_timer, countdown_timer) {
        if (remain_timer >= 0 || winner > -1) {
            let new_minutes = Math.floor(remain_timer / 60);
            new_minutes = new_minutes >= 0 ? new_minutes : 0;
            let new_seconds = remain_timer % 60;
            new_seconds = new_seconds >= 0 ? new_seconds : 0;
            setMinutes(new_minutes);
            setSeconds(new_seconds);
        } else {
            // Hết giờ
            clearInterval(countdown_timer);
            setPlay(false);
            const res = await axios({
                method: "patch",
                url: "/api/battleground/" + battleground_id,
                data: {
                    fighter_id: fighter_id,
                },
            })
                .then(function (res) {
                    // console.log(res);
                })
                .catch(function (err) {
                    console.log(err);
                });
        }
    }

    function addZero(unit) {
        return unit < 10 ? "0" + unit : unit;
    }
    // Math.round(Date.now()/1000)
    useEffect(() => {
        if (count) {
            const countdown_timer = setInterval(() => {
                const remain_timer = end_timer - Math.round(Date.now() / 1000);
                setTimer(remain_timer, countdown_timer);
            }, 1000);
            return () => clearInterval(countdown_timer);
        } else {
            const remain_timer = end_timer - time_point;
            setTimer(remain_timer);
        }
    }, [end_timer, count]);

    return (
        <h1
            className={
                "text-h2 " +
                (minutes == 0 && seconds <= 15
                    ? " text-red"
                    : " text-[#071952]")
            }
        >
            {addZero(minutes) + ":" + addZero(seconds)}
        </h1>
    );
}
