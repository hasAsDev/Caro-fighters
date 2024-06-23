import React from "react";

export default function Fighter({ fighter, XO }) {
    return (
        <div className="text-center">
            <h1 className="text-h1 font-h1 text-brown-active font-norse">
                {fighter.name}
            </h1>
            <p className="text-txt font-txt text-brown font-norse">
                Score: 1000
            </p>
            <h1 className="text-h2 font-h2 text-brown-active font-norse">
                {XO}
            </h1>
            <h1 className="text-h2 font-h2 text-red">5:00</h1>
        </div>
    );
}
