/**
 * Thirft example DDL
 *
 * Osman Yuksel < yuxel {{|AT|}} sonsuzdongu |-| com >
 */
namespace php Example
service Example{
    // return current time stamp
    string showCurrentTimestamp()
     
    // wait for 10 seconds, but work asynchronously
    oneway void asynchronousJob()
}
