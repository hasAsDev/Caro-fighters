import React from "react";
import Board from "./Board";
import Fighter from "./Fighter";
import { useEffect, useState } from "react";
import axios from "axios";

const battleground_id = document
    .getElementById("entry_battleground")
    .getAttribute("battleground_id");

const fighter_id = document.body.getAttribute("fighter_id");

export default function Game() {
    const [battle_record, setBattle_record] = useState([
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
    ]);

    const [turn, setTurn] = useState("");
    const [winner, setWinner] = useState(-1);

    const [x_timer, setX_timer] = useState(0);
    const [o_timer, setO_timer] = useState(0);
    const [time_point, setTime_point] = useState(0);

    const [fighter_X, setFighter_X] = useState({
        name: "XXXXX",
        elo: 0,
    });

    const [fighter_O, setFighter_O] = useState({
        name: "OOOOO",
        elo: 0,
    });

    const [win_XO, setWin_XO] = useState("count");

    const [play, setPlay] = useState(false);

    async function getBattleground() {
        const res = await axios
            .get("/api/battleground/" + battleground_id)
            .then(function (res) {
                // handle success
                setBattle_record(res.data.battleground.battle_record);
                setFighter_X(res.data.fighter_X);
                setFighter_O(res.data.fighter_O);
                setWin_XO(res.data.win_XO);
                setTurn(res.data.battleground.turn);
                setWinner(res.data.battleground.winner);
                setX_timer(res.data.battleground.X_timer);
                setO_timer(res.data.battleground.O_timer);
                setTime_point(res.data.battleground.time_point);
                // Kiểm tra lượt
                if (
                    (res.data.battleground.turn == "X" &&
                        fighter_id == res.data.battleground.fighter_X) ||
                    (res.data.battleground.turn == "O" &&
                        fighter_id == res.data.battleground.fighter_O)
                ) {
                    setPlay(true);
                }
            })
            .catch(function (err) {
                window.location.replace("/battle");
            });
    }

    function connectReverb() {
        window.Echo.private(
            "channel_for_battleground_" + battleground_id
        ).listen("BattleUpdated", (e) => {
            getBattleground();
        });
    }

    useEffect(() => {
        getBattleground();
        connectReverb();
    }, []);

    // Kiểm tra chiến thắng

    return (
        <>
            <div className="flex flex-col tablet:flex-row justify-evenly items-center py-10">
                <Fighter
                    player={play}
                    setPlay={setPlay}
                    XO={"X"}
                    fighter={fighter_X}
                    end_timer={x_timer}
                    time_point={time_point}
                    count={turn === "X"}
                    winner={winner}
                    win_XO={win_XO}
                />
                <Board
                    battle_record={battle_record}
                    setBattle_record={setBattle_record}
                    play={play}
                    setPlay={setPlay}
                ></Board>
                <Fighter
                    player={play}
                    setPlay={setPlay}
                    XO={"O"}
                    fighter={fighter_O}
                    end_timer={o_timer}
                    time_point={time_point}
                    count={turn === "O"}
                    winner={winner}
                    win_XO={win_XO}
                />
            </div>
        </>
    );
}
