import React from "react";
import { useState, useEffect } from "react";
import Timer from "./Timer";

export default function Fighter({
    setPlay,
    fighter,
    XO,
    end_timer,
    time_point,
    count,
    winner,
    win_XO,
}) {
    return (
        <div
            className={
                "text-center flex tablet:flex-col space-y-4" +
                (XO === "X" ? " flex-col " : " flex-col-reverse ")
            }
        >
            {win_XO == XO ? (
                <h1
                    className={
                        "text-h2 font-h2 text-brown-active font-norse " + " "
                    }
                >
                    Win
                </h1>
            ) : win_XO == "Draw" ? (
                <h1
                    className={
                        "text-h2 font-h2 text-brown-active font-norse " + " "
                    }
                >
                    Draw
                </h1>
            ) : (
                <h1
                    className={
                        "text-h2 font-h2 text-brown-active font-norse invisible" +
                        " "
                    }
                >
                    XOXOXOXO
                </h1>
            )}
            <h1
                className={
                    "text-h1 font-h1 text-brown font-norse " +
                    (count || win_XO == XO || win_XO == "Draw"
                        ? " text-brown-active"
                        : "")
                }
            >
                {fighter.name}
            </h1>
            <p className="text-txt font-txt text-green  font-norse">
                Elo: {fighter.elo}
            </p>
            <h1 className="text-h2 font-h2 text-brown-active font-norse flex justify-center">
                {XO == "X" ? (
                    <svg
                        className="size-4 laptop:size-8"
                        width="360"
                        height="360"
                        viewBox="0 0 360 360"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <rect
                            x="63.4975"
                            y="346.34"
                            width="70"
                            height="400"
                            rx="5"
                            transform="rotate(-135 63.4975 346.34)"
                            fill="#8B322C"
                        />
                        <rect
                            x="14"
                            y="63.4975"
                            width="70"
                            height="400"
                            rx="5"
                            transform="rotate(-45 14 63.4975)"
                            fill="#8B322C"
                        />
                    </svg>
                ) : XO == "O" ? (
                    <svg
                        className="size-4 laptop:size-8"
                        width="360"
                        height="360"
                        viewBox="0 0 360 360"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <circle
                            cx="180"
                            cy="180"
                            r="125"
                            stroke="#FEFFD2"
                            strokeWidth="70"
                        />
                    </svg>
                ) : (
                    ""
                )}
            </h1>
            <Timer
                end_timer={end_timer}
                time_point={time_point}
                count={count}
                setPlay={setPlay}
                winner={winner}
            />
        </div>
    );
}
