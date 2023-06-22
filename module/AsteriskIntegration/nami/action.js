/* global __dirname */

message = require(__dirname + '/message.js');
util = require('util');

function Action(name)
{
    Action.super_.call(this);
    this.id = ActionUniqueId();
    this.set('ActionID', this.id);
    this.set('Action', name);
}

var ActionUniqueId = (function ()
{
    var nextId = 0;
    return function ()
    {
        return nextId++;
    };
})();

function Login(username, secret)
{
    Login.super_.call(this, 'Login');
    this.set('Username', username);
    this.set('Secret', secret);
}

function CoreShowChannels()
{
    CoreShowChannels.super_.call(this, 'CoreShowChannels');
}

function Ping()
{
    Ping.super_.call(this, 'Ping');
}

function Hangup()
{
    Hangup.super_.call(this, 'Hangup');
}

function CoreStatus()
{
    CoreStatus.super_.call(this, 'CoreStatus');
}

function Status()
{
    Status.super_.call(this, 'Status');
}

function DahdiShowChannels()
{
    DahdiShowChannels.super_.call(this, 'DahdiShowChannels');
}

function CoreSettings()
{
    CoreSettings.super_.call(this, 'CoreSettings');
}

function ListCommands()
{
    ListCommands.super_.call(this, 'ListCommands');
}

function Logoff()
{
    Logoff.super_.call(this, 'Logoff');
}

function AbsoluteTimeout()
{
    AbsoluteTimeout.super_.call(this, 'AbsoluteTimeout');
}

function SipShowPeer()
{
    SipShowPeer.super_.call(this, 'SIPshowpeer');
}

function SipShowRegistry()
{
    SipShowRegistry.super_.call(this, 'SIPshowregistry');
}

function SipQualifyPeer()
{
    SipQualifyPeer.super_.call(this, 'SIPqualifypeer');
}

function SipPeers()
{
    SipPeers.super_.call(this, 'SIPpeers');
}

function AgentLogoff()
{
    AgentLogoff.super_.call(this, 'AgentLogoff');
}

function Agents()
{
    Agents.super_.call(this, 'Agents');
}

function AttendedTransfer()
{
    AttendedTransfer.super_.call(this, 'Atxfer');
}

function ChangeMonitor()
{
    ChangeMonitor.super_.call(this, 'ChangeMonitor');
}

function Command()
{
    Command.super_.call(this, 'Command');
}

function CreateConfig()
{
    CreateConfig.super_.call(this, 'CreateConfig');
}

function DahdiDialOffHook()
{
    DahdiDialOffHook.super_.call(this, 'DahdiDialOffHook');
}

function DahdiDndOff()
{
    DahdiDndOff.super_.call(this, 'DahdiDndOff');
}

function DahdiDndOn()
{
    DahdiDndOn.super_.call(this, 'DahdiDndOn');
}

function DahdiHangup()
{
    DahdiHangup.super_.call(this, 'DahdiHangup');
}

function DahdiRestart()
{
    DahdiRestart.super_.call(this, 'DahdiRestart');
}

function DbDel()
{
    DbDel.super_.call(this, 'DbDel');
}

function DbDeltree()
{
    DbDeltree.super_.call(this, 'DbDeltree');
}

function DbGet()
{
    DbGet.super_.call(this, 'DbGet');
}

function DbPut()
{
    DbPut.super_.call(this, 'DbPut');
}

function ExtensionState()
{
    ExtensionState.super_.call(this, 'ExtensionState');
}

function GetConfig()
{
    GetConfig.super_.call(this, 'GetConfig');
}

function GetConfigJson()
{
    GetConfigJson.super_.call(this, 'GetConfigJson');
}

function GetVar()
{
    GetVar.super_.call(this, 'GetVar');
}

function PJSIPNotify()
{
    PJSIPNotify.super_.call(this, 'PJSIPNotify');
}

function JabberSend()
{
    JabberSend.super_.call(this, 'JabberSend');
}

function ListCategories()
{
    ListCategories.super_.call(this, 'ListCategories');
}

function PauseMonitor()
{
    PauseMonitor.super_.call(this, 'PauseMonitor');
}

function UnpauseMonitor()
{
    UnpauseMonitor.super_.call(this, 'UnpauseMonitor');
}

function StopMonitor()
{
    StopMonitor.super_.call(this, 'StopMonitor');
}

function LocalOptimizeAway()
{
    LocalOptimizeAway.super_.call(this, 'LocalOptimizeAway');
}

function SetVar()
{
    SetVar.super_.call(this, 'SetVar');
}

function Reload()
{
    Reload.super_.call(this, 'Reload');
}

function PlayDtmf()
{
    PlayDtmf.super_.call(this, 'PlayDtmf');
}

function Park()
{
    Park.super_.call(this, 'Park');
}

function ParkedCalls(lot)
{
    ParkedCalls.super_.call(this, 'ParkedCalls');

    if (undefined !== lot)
    {
        this.set('ParkingLot', lot);
    }

}

function Parkinglots()
{
    Parkinglots.super_.call(this, 'Parkinglots');
}

function Monitor()
{
    Monitor.super_.call(this, 'Monitor');
    this.format = 'wav';
    this.mix = 'true';
}

function ModuleCheck()
{
    ModuleCheck.super_.call(this, 'ModuleCheck');
}

function ModuleLoad()
{
    ModuleLoad.super_.call(this, 'ModuleLoad');
    this.LoadType = 'load';
}

function ModuleUnload()
{
    ModuleUnload.super_.call(this, 'ModuleUnload');
    this.LoadType = 'unload';
}

function ModuleReload()
{
    ModuleReload.super_.call(this, 'ModuleReload');
    this.LoadType = 'reload';
}

function MailboxCount()
{
    MailboxCount.super_.call(this, 'MailboxCount');
}

function MailboxStatus()
{
    MailboxStatus.super_.call(this, 'MailboxStatus');
}

function VoicemailUsersList()
{
    VoicemailUsersList.super_.call(this, 'VoicemailUsersList');
}

function Redirect()
{
    Redirect.super_.call(this, 'Redirect');
}

function Bridge()
{
    Bridge.super_.call(this, 'Bridge');
}

function ShowDialPlan()
{
    ShowDialPlan.super_.call(this, 'ShowDialPlan');
}

function SendText()
{
    SendText.super_.call(this, 'SendText');
}

function Queues()
{
    Queues.super_.call(this, 'Queues');
}

function QueueReload(queue, members, rules, parameters)
{
    QueueReload.super_.call(this, 'QueueReload');

    if (undefined !== queue)
    {
        this.set('queue', queue);
    }

    if (undefined !== members)
    {
        this.set('members', members);
    }

    if (undefined !== rules)
    {
        this.set('rules', rules);
    }

    if (undefined !== parameters)
    {
        this.set('parameters', parameters);
    }
}

function QueueUnpause(asteriskInterface, queue, reason)
{
    QueueUnpause.super_.call(this, 'QueuePause');
    this.set('paused', 'false');
    this.set('interface', asteriskInterface);

    if (undefined !== queue)
    {
        this.set('queue', queue);
    }

    if (undefined !== reason)
    {
        this.set('reason', reason);
    }
}

function QueuePause(asteriskInterface, queue, reason)
{
    QueuePause.super_.call(this, 'QueuePause');
    this.set('paused', 'true');
    this.set('interface', asteriskInterface);

    if (undefined !== queue)
    {
        this.set('queue', queue);
    }

    if (undefined !== reason)
    {
        this.set('reason', reason);
    }
}

function QueueSummary(queue)
{
    QueueSummary.super_.call(this, 'QueueSummary');
    if (undefined !== queue)
    {
        this.set('Queue', queue);
    }
}

function QueueRule()
{
    QueueRule.super_.call(this, 'QueueRule');
}

function QueueStatus(queue, member)
{
    QueueStatus.super_.call(this, 'QueueStatus');
    if (undefined !== queue)
    {
        this.set('Queue', queue);
    }
    if (undefined !== member)
    {
        this.set('Member', member);
    }
}

function QueueReset()
{
    QueueReset.super_.call(this, 'QueueReset');
}

function QueueRemove(asteriskInterface, queue)
{
    QueueRemove.super_.call(this, 'QueueRemove');
    this.set('interface', asteriskInterface);
    this.set('queue', queue);
}

function Originate()
{
    Originate.super_.call(this, 'Originate');
}

function QueueAdd(asteriskInterface, queue, paused, memberName, penalty)
{
    QueueAdd.super_.call(this, 'QueueAdd');
    this.set('interface', asteriskInterface);
    this.set('queue', queue);
    if (undefined !== paused)
    {
        this.set('paused', paused);
    }
    if (undefined !== memberName)
    {
        this.set('membername', memberName);
    }
    if (undefined !== penalty)
    {
        this.set('penalty', penalty);
    }
}

function QueueLog()
{
    QueueLog.super_.call(this, 'QueueLog');
}

function MeetmeList(conference)
{
    MeetmeList.super_.call(this, 'MeetmeList');
    if (conference !== null)
    {
        this.set('Conference', conference);
    }
}

function MeetmeMute(meetme, usernum)
{
    MeetmeMute.super_.call(this, 'MeetmeMute');
    this.set('Meetme', meetme);
    this.set('Usernum', usernum);
}

function MeetmeUnmute(meetme, usernum)
{
    MeetmeUnmute.super_.call(this, 'MeetmeUnmute');
    this.set('Meetme', meetme);
    this.set('Usernum', usernum);
}

function ConfbridgeListRooms()
{
    ConfbridgeListRooms.super_.call(this, 'ConfbridgeListRooms');
}

function ConfbridgeList(conference)
{
    ConfbridgeList.super_.call(this, 'ConfbridgeList');
    this.set('Conference', conference);
}

function ConfbridgeKick(conference, channel)
{
    ConfbridgeKick.super_.call(this, 'ConfbridgeKick');
    this.set('Conference', conference);
    this.set('Channel', channel);
}

function ConfbridgeLock(conference)
{
    ConfbridgeLock.super_.call(this, 'ConfbridgeLock');
    this.set('Conference', conference);
}

function ConfbridgeUnlock(conference)
{
    ConfbridgeUnlock.super_.call(this, 'ConfbridgeUnlock');
    this.set('Conference', conference);
}

function ConfbridgeMute(conference, channel)
{
    ConfbridgeMute.super_.call(this, 'ConfbridgeMute');
    this.set('Conference', conference);
    this.set('Channel', channel);
}

function ConfbridgeUnmute(conference, channel)
{
    ConfbridgeUnmute.super_.call(this, 'ConfbridgeUnmute');
    this.set('Conference', conference);
    this.set('Channel', channel);
}

function AGI(channel, command, commandId)
{
    AGI.super_.call(this, 'AGI');
    this.set('Channel', channel);
    this.set('Command', command);
    this.set('CommandID', commandId);
}

function BlindTransfer(channel, context, extension)
{
    BlindTransfer.super_.call(this, 'BlindTransfer');
    this.set('Channel', channel);
    this.set('Context', context);
    this.set('Exten', extension);
}

function Filter(operation, filter)
{
    Filter.super_.call(this, 'Filter');
    this.set('Operation', operation);
    this.set('Filter', filter);
}

function UserEvent(event)
{
    UserEvent.super_.call(this, 'UserEvent');
    this.set('UserEvent', event);
}

function Events(mask)
{
    Events.super_.call(this, 'Events');
    this.set('Eventmask', mask);
}

// Inheritance for this module
util.inherits(Action, message.Message);
(function ()
{
    var i;
    var actions = [
        Login,
        Logoff,
        Ping,
        Hangup,
        CoreShowChannels,
        CoreStatus,
        CoreSettings,
        Status,
        DahdiShowChannels,
        ListCommands,
        AbsoluteTimeout,
        SipShowPeer,
        SipShowRegistry,
        SipQualifyPeer,
        SipPeers,
        AgentLogoff,
        Agents,
        AttendedTransfer,
        ChangeMonitor,
        Command,
        CreateConfig,
        DahdiDialOffHook,
        DahdiDndOff,
        DahdiDndOn,
        DahdiHangup,
        DahdiRestart,
        DbDel,
        DbDeltree,
        DbGet,
        DbPut,
        ExtensionState,
        GetConfig,
        GetConfigJson,
        GetVar,
        SetVar,
        JabberSend,
        PJSIPNotify,
        ListCategories,
        PauseMonitor,
        LocalOptimizeAway,
        Reload,
        PlayDtmf,
        Park,
        ParkedCalls,
        Parkinglots,
        Monitor,
        ModuleCheck,
        ModuleLoad,
        ModuleUnload,
        ModuleReload,
        MailboxCount,
        MailboxStatus,
        VoicemailUsersList,
        Originate,
        Redirect,
        Bridge,
        UnpauseMonitor,
        StopMonitor,
        ShowDialPlan,
        SendText,
        Queues,
        QueueUnpause,
        QueuePause,
        QueueReset,
        QueueSummary,
        QueueStatus,
        QueueRemove,
        QueueRule,
        QueueAdd,
        QueueLog,
        QueueReload,
        MeetmeList,
        MeetmeMute,
        MeetmeUnmute,
        ConfbridgeListRooms,
        ConfbridgeList,
        ConfbridgeKick,
        ConfbridgeLock,
        ConfbridgeUnlock,
        ConfbridgeMute,
        ConfbridgeUnmute,
        AGI,
        BlindTransfer,
        Filter,
        Events,
        UserEvent
    ];
    for (i in actions)
    {
        util.inherits(actions[i], Action);
        exports[actions[i].name] = actions[i];
    }
})();
