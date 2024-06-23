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
    const [battleground, setBattleground] = useState({
        fighter_X: null,
        fighter_O: null,
        winner: -1,
        turn: null,
        battle_record: [
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
        ],
    });

    const [fighter_X, setFighter_X] = useState({
        name: "XXXXX",
    });

    const [fighter_O, setFighter_O] = useState({
        name: "OOOOO",
    });

    const [play, setPlay] = useState(false);

    async function getBattleground() {
        const res = await axios
            .get("/api/battleground/" + battleground_id)
            .then(function (res) {
                // handle success
                setBattleground(res.data.battleground);
                setFighter_X(res.data.fighter_X);
                setFighter_O(res.data.fighter_O);
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
            <div className="flex flex-col tablet:flex-row justify-evenly items-center">
                <Fighter fighter={fighter_X} XO={"X"} />
                <Board
                    battle_record={battleground.battle_record}
                    play={play}
                    setPlay={setPlay}
                ></Board>
                <Fighter fighter={fighter_O} XO={"O"} />
            </div>
        </>
    );
}
